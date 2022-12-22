from minio import Minio

client = Minio(
        "localhost:9000",
        access_key="minioadmin",
        secret_key="minioadmin",
        secure=False
    )

# Get a full object
data = client.get_object('rachmaputri', 'peopledata.csv')

with open('my-testfile', 'wb') as file_data:
    for d in data:
        file_data.write(d)

