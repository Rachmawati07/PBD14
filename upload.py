from minio import Minio
from minio.error import S3Error


def main():
    # Create a client with the MinIO server playground, its access key
    # and secret key.
    client = Minio(
        "localhost:9000",
        access_key="minioadmin",
        secret_key="minioadmin",
        secure=False
    )

    # Make 'rachmaputri' bucket if not exist.
    found = client.bucket_exists("rachmaputri")
    if not found:
        client.make_bucket("rachmaputri")
    else:
        print("Bucket 'rachmaputri' already exists")

    # Upload 'C:\Python-Minio\peopledata.csv' as object name
    # 'peopledata.csv' to bucket 'rachmaputri'.
    client.fput_object(
        "rachmaputri", "peopledata.csv", "C:\Python-Minio\peopledata.csv",
    )
    print(
        "'C:\Python-Minio\peopledata.csv' is successfully uploaded as "
        "object 'peopledata.csv' to bucket 'rachmaputri'."
    )


if __name__ == "__main__":
    try:
        main()
    except S3Error as exc:
        print("error occurred.", exc)