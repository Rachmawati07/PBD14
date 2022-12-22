# Imports pandas
import pandas as pd
# import library mongo
import pymongo 
# import minio
from minio import Minio

#Buat koneksi ke minio
client = Minio(
        "localhost:9000",
        access_key="minioadmin",
        secret_key="minioadmin",
        secure=False
    )

# buat koneksi ke server MongoDB
clientMongo = pymongo.MongoClient("mongodb://localhost:27017")

# buat database baru 
db = clientMongo["db_data"]

# buat collection
col = db["data_manusia"]


# Get a full object
object_data = client.get_object('rachmaputri', 'peopledata.csv')
data_dict = pd.DataFrame(pd.read_csv(object_data))
data_dict = data_dict.to_dict(orient="records")
col.insert_many(data_dict)

if col.inserted_ids is not None:
    print("Data telah berhasil disimpan pada mongoDB")
else :
    print("Data gagal disimpan pada mongoDB")