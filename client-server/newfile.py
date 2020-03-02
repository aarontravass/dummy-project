import os
import datetime
import json
import mysql.connector
import random
import struct
from google.cloud import bigtable
from google.cloud.bigtable import column_family
from google.oauth2 import service_account


credentials = service_account.Credentials.from_service_account_file('sih.json')
scoped_credentials = credentials.with_scopes(['https://www.googleapis.com/auth/cloud-platform'])
project_id=''
instance_id='accidentdb'
table_id='accident'
client = bigtable.Client(project=project_id, admin=True,credentials=credentials)
instance = client.instance(instance_id)
print('Creating the {} table.'.format(table_id))
table = instance.table(table_id)
max_age_rule = column_family.MaxAgeGCRule(datetime.timedelta(days=1))

run=True
while(run):
     files=os.listdir('/media/json/')
     if(len(files)==0):
          continue
     else:
          current=files[0]
          with open('/media/json/'+current,"r") as f:
               temp = json.load(f)
          POST={}
          POST[0]=temp[0]
          POST[1] = temp[1]
          POST[2] = random.randrange(10000,999999)
          
          
          conn=mysql.connector.connect(host="",user="",passwd="",database="accident")
          mycursor=conn.cursor()

          sql="insert into accidentdb values(null,%s,%s,%s,%s,null,null,null,null,null,null,null);"
          val=(POST[2],datetime.datetime.now(), POST[0],POST[1])
          mycursor.execute(sql,val)
          conn.commit()
          file = open("last.txt","r") 
          row=10002
          file.close()
          file=open("last.txt","w")
          file.write(str(int(row)))
          file.close()
          
          #run=False

          column_family_id = 'location'
          
          row_key = 'Location{}'.format(row).encode()
          long = POST[1]
          lat = POST[0]
          row = table.direct_row(row_key)
          long_data = struct.pack('>d', float(long))
          lat_data = struct.pack('>d', float(lat))
          row.set_cell(column_family_id,
                       'Longitude',
                       long_data,
                       timestamp=datetime.datetime.utcnow())
          row.set_cell(column_family_id,
                       'Latitude',
                       lat_data,
                       timestamp=datetime.datetime.utcnow())
          
          row.commit()

          
          with open("/media/data/"+temp[2]+'.json', 'w') as outfile:
               json.dump(POST, outfile)
          #print('Successfully wrote row {}.'.format(row_key))
          os.remove('/media/json/'+current)
          #os.system()
          #print(mycursor.rowcount)


