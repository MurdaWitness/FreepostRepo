# Библиотеки
import json
import random
import sys
import vk_api as api


# Проверка на количество аргументов
if (len(sys.argv) < 4):
    sys.exit("Too few arguments")

# Объект сессии
VK = None

module_id = None

postpath = sys.argv[1]
postdata = None

group_id = None
album_id = None

# Аргументы для wall.post
text = ""

image_paths = []

video_paths = []
video_links = []

file_paths = []

attachment_list = []

post_attachments = []


def user_authorize():
    """User authorization by token
    """
    session = api.VkApi(token=sys.argv[2])
    global VK
    VK = session.get_api()


def parse_manifest():
    """Parses manifest to find module_id
    """
    with open('manifest.json', 'r') as file:
        manifestdata = json.load(file)
        global module_id
        module_id = manifestdata["moduleID"]


def parse_post_metadata():
    """Parses post metadata
    """
    arguments = postdata["metadata"][module_id]

    # TODO
    # Не совсем уверен, нужны ли тут ифы для groupName и albumName
    if "groupName" in arguments:
        user_id = VK.users.get()[0]["id"]

        groups = VK.groups.get(
            user_id=user_id, filter="moder", extended=1)["items"]

        for group in groups:
            if group["name"] == arguments["groupName"]:
                global group_id
                group_id = str(group["id"])
                break

        # Проверка, что group_id совпадает с указанным в метаданных поста
        if group_id is None:
            sys.exit("group_id equals None")

    if "albumName" in arguments:
        albums = VK.photos.getAlbums(owner_id="-" + group_id)["items"]

        for album in albums:
            if album["title"] == arguments["albumName"]:
                global album_id
                album_id = str(album["id"])
                break

        # Проверка, что album_id совпадает с указанным в метаданных поста
        if album_id is None:
            sys.exit("album_id equals None")


def parse_post_data():
    """Parses the content of the post
    """
    for datablock in postdata["dataBlocks"]:

        if datablock["blockType"] == 'Text':
            global text
            text += datablock["blockData"]

        elif datablock["blockType"] == 'Image':
            image_paths.append(datablock["blockData"])

        elif datablock["blockType"] == 'Video':
            if datablock["blockData"].startswith("http"):
                video_links.append(datablock["blockData"])
            else:
                video_paths.append(datablock["blockData"])

        elif datablock["blockType"] == 'File':
            file_paths.append(datablock["blockData"])

        elif datablock["blockType"] == 'Attachment':
            attachment_list.append(datablock["blockData"])


def prepare_attachments():
    """Prepares attachments to be sent later with the post
    """
    if len(image_paths) + len(video_paths) + len(video_links) + len(file_paths):
        upload = api.upload.VkUpload(VK)

    if len(image_paths):
        upload_photos(upload)

    if len(video_paths) + len(video_links):
        upload_videos(upload)

    if len(file_paths):
        upload_files(upload)

    if len(attachment_list):
        append_attachments()


def upload_photos(upload):
    """Uploads photos to server

    Args:
        upload (VkUpload): Vk Upload object
    """
    photos = upload.photo(photos=image_paths,
                          album_id=album_id, group_id=group_id)

    global post_attachments

    for photo in photos:
        photo_id = photo['id']
        attachment = "photo" + "-" + group_id + "_" + str(photo_id)
        post_attachments.append(attachment)


def upload_videos(upload):
    """Uploads videos to server

    Args:
        upload (VkUpload): Vk Upload object
    """
    videos = []

    for path in video_paths:
        videos.append(upload.video(video_file=path, group_id=group_id))

    for link in video_links:
        videos.append(upload.video(link=link, group_id=group_id))

    global post_attachments

    for video in videos:
        video_id = video['video_id']
        attachment = "video" + "-" + group_id + "_" + str(video_id)
        post_attachments.append(attachment)


def upload_files(upload):
    """Uploads files to server

    Args:
        upload (VkUpload): Vk Upload object
    """
    documents = []

    for file in file_paths:
        documents.append(upload.document(
            doc=file, title=file.split("/")[-1], group_id=group_id))

    global post_attachments

    for document in documents:
        document_id = document['doc']['id']
        attachment = "doc" + "-" + group_id + "_" + str(document_id)
        post_attachments.append(attachment)


def append_attachments():
    """Appends attachments to the attachment list
    """
    global post_attachments

    for attachment in attachment_list:
        post_attachments.append(attachment)


def make_post():
    """Uploads files to the server and creates a post with attachments
    """
    prepare_attachments()
    random_id = random.randint(-2147483648, 2147483647)
    VK.wall.post(owner_id="-" + group_id, from_group="1", message=text,
                 attachments=post_attachments, guid=str(random_id))


# Типа main
user_authorize()
parse_manifest()
with open(postpath, 'r', encoding="utf-8") as file:
    postdata = json.load(file)
parse_post_metadata()
parse_post_data()
make_post()
print("Post has been successfully made")
