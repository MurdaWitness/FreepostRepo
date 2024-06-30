import json
import os
import re
import requests
import sys

postpath = sys.argv[1]


def check_additional_args():
    """Checks additional arguments in the post metadata by module id

    Raises:
        ValueError: Too few arguments
        TypeError: The additional arguments passed do not match the arguments from the manifest
    """
    if len(metadata[module_id]) < 1:
        raise ValueError("Too few additional arguments.")

    # TODO
    # Возможно следующую монструозную конструкцию можно упростить
    manifest_args = []
    for arg in additional_args:
        manifest_args.append(arg["argumentName"])

    post_args = metadata[module_id].keys()

    for arg in post_args:
        if arg not in manifest_args:
            raise TypeError(
                "The additional arguments passed do not match the arguments from the manifest.")


def check_supported_type():
    """Checks supported datablock types

    Raises:
        TypeError: BlockType is not supported
    """
    for datablock in datablocks:
        if not datablock["blockType"] in blocktypes:
            raise TypeError("BlockType is not supported.")


def check_quantity():
    """Checks datablock quantity

    Raises:
        ValueError: Too many attachments
        ValueError: Too many text blocks
    """
    datablocks = postdata["dataBlocks"]
    attachment_count = 0
    text_count = 0

    for datablock in datablocks:
        if datablock["blockType"] == "Text":
            text_count += 1
        else:
            attachment_count += 1

    if attachment_count > 10:
        raise ValueError("Too many attachments.")

    if text_count > 1:
        raise ValueError("Too many text blocks.")


def check_matching_type():
    """Validates each datablock according to its type
    """
    datablocks = postdata["dataBlocks"]

    for datablock in datablocks:

        if datablock["blockType"] == "Text":
            validate_text(datablock)

        elif datablock["blockType"] == "Image":
            validate_image(datablock)

        elif datablock["blockType"] == "Video":
            validate_video(datablock)

        elif datablock["blockType"] == "File":
            validate_file(datablock)

        elif datablock["blockType"] == "Attachment":
            validate_attachment(datablock)


def validate_text(datablock):
    """Validates datablock "Text"

    Args:
        datablock (dict): Datablock containing text of the post

    Raises:
        ValueError: Text length is too big
    """
    text = datablock["blockData"]
    maxsize = 15895

    if len(text) > maxsize:
        raise ValueError("Text length is too big.")


def validate_image(datablock):
    """Validates datablock "Image"

    Args:
        datablock (dict): Datablock containing image file location

    Raises:
        ValueError: Image does not exist
        TypeError: Image type is not supported
        ValueError: Image size is too big
    """
    image = datablock["blockData"]
    types = ["jpg", "jpeg", "png", "gif", "tif", "tiff"]
    maxsize = 52428800

    if not os.path.exists(image):
        raise ValueError("Image does not exist.")

    if not image.split(".")[-1].lower() in types:
        raise TypeError("Image type is not supported.")

    if os.path.getsize(image) > maxsize:
        raise ValueError("Image size is too big.")


def validate_video(datablock):
    """Validates datablock "Video"

    Args:
        datablock (dict): Datablock containing video file location / Internet link to the video
    """
    video = datablock["blockData"]

    if video.startswith("http"):
        validate_video_link(video)
    else:
        validate_video_file(video)


def validate_video_file(video):
    """Validates video file

    Args:
        video (string): Video file location

    Raises:
        ValueError: Video does not exist
        TypeError: Video type is not supported
        ValueError: Video size is too big
    """
    types = ["avi", "mp4", "3gp", "mpeg", "mov", "flv", "f4v", "wmv", "mkv",
             "webm", "vob", "rm", "rmvb", "m4v", "mpg", "ogv", "ts", "m2ts", "mts"]
    maxsize = 2147483648

    if not os.path.exists(video):
        raise ValueError("Video does not exist.")

    if not video.split(".")[-1].lower() in types:
        raise TypeError("Video type is not supported.")

    if os.path.getsize(video) > maxsize:
        raise ValueError("Video size is too big.")


def validate_video_link(url):
    """Validates video from the Internet

    Args:
        url (string): Internet link to video
    """
    url_valid(url)
    url_exists(url)


def url_valid(url):
    """Checks if the link is a valid URL

    Args:
        url (string): Internet link to video in format https://example.com/some-video-parameters

    Raises:
        TypeError: Provided string is not a url
    """
    regex = re.compile(
        r'^(http|https)://'  # Проверка на http или https
        r'(www\.)?'  # www, может отсутствовать
        r'([a-z0-9-]{2,63})'  # Доменное имя 2-го уровня
        r'\.'  # Доменное имя 0-го уровня
        r'([a-z]{2,19})'  # Доменное имя 1-го уровня
        r'(/.*)?$',  # Произвольные данные после последнего слэша
        re.IGNORECASE)
    if re.match(regex, url) is None:
        raise TypeError("Provided string is not a url.")


def url_exists(url):
    """Sends a request to a URL to see if it exists

    Args:
        url (string): Internet link to video

    Raises:
        ValueError: Bad status code
    """
    response = requests.head(url, allow_redirects=True)
    if not response.status_code == 200:
        raise ValueError("Bad status code.")


def validate_file(datablock):
    """Validates datablock "File"

    Args:
        datablock (dict): Datablock containing file location

    Raises:
        ValueError: File does not exist
        TypeError: File type is not supported
        ValueError: File size is too big
    """
    file = datablock["blockData"]
    unsupported_types = ["apk", "exe", "jar", "bat", "mp3", "m4a"]
    maxsize = 2147483648

    if not os.path.exists(file):
        raise ValueError("File does not exist.")

    if file.split(".")[-1].lower() in unsupported_types:
        raise TypeError("File type is not supported.")

    if os.path.getsize(file) > maxsize:
        raise ValueError("File size is too big.")


def validate_attachment(datablock):
    """Validates datablock "Attachment"

    Args:
        datablock (dict): Datablock containing attachment string in format {type}{owner_id}_{media_id}

    Raises:
        TypeError: Provided string is not an attachment
    """
    attachment = datablock["blockData"]
    regex = re.compile(
        # Проверка на тип аттачмента
        r'^(photo|video|audio|doc|page|note|poll|album|market|market_album|audio_playlist)'
        r'(-?)'  # Проверка на принадлежность группе
        r'([0-9]{9})'  # Идентификатор владельца медиавложения
        r'_'  # Нижнее подчёркивание
        r'([0-9]{9})'  # Идентификатор медиавложения
        # 18-ти символьный дополнительный код для аудио (не обязательно)
        r'(_[a-z0-9]{18})?$',
        re.IGNORECASE)
    if re.match(regex, attachment) is None:
        raise TypeError("Provided string is not an attachment.")


# Типа main
with open('manifest.json', 'r') as file:
    manifestdata = json.load(file)

additional_args = manifestdata["additionalArguments"]
blocktypes = manifestdata["blockTypes"]
module_id = manifestdata["moduleID"]

with open(postpath, 'r') as file:
    postdata = json.load(file)

metadata = postdata["metadata"]
datablocks = postdata["dataBlocks"]

check_additional_args()
check_supported_type()
check_quantity()
check_matching_type()
print("Validation has been successful")
