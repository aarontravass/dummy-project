
# coding: utf-8

# In[2]:


import pandas as pd
import datetime
import struct
from google.cloud import bigtable
from google.cloud.bigtable import column_family
from google.cloud.bigtable import row_filters
import matplotlib.pyplot as plt
from sklearn.cluster import DBSCAN
import sklearn.utils
from sklearn.preprocessing import StandardScaler
import numpy as np


# In[3]:


df=pd.read_csv('loc.csv')


# In[4]:


df.head()


# In[5]:


df.shape


# In[6]:


df.drop(columns=[df.columns[0],
                 ],inplace=True)
df.head()


# In[7]:


df['Longitude'][0]


# In[8]:


from google.oauth2 import service_account

credentials = service_account.Credentials.from_service_account_file(
    'sih.json')

scoped_credentials = credentials.with_scopes(
    ['https://www.googleapis.com/auth/cloud-platform'])


# In[9]:


project_id='' 
instance_id='accidentdb'
table_id='accident'


# In[10]:


client = bigtable.Client(project=project_id, admin=True,credentials=credentials)
instance = client.instance(instance_id)


# In[11]:


print('Creating the {} table.'.format(table_id))
table = instance.table(table_id)


# In[12]:


max_age_rule = column_family.MaxAgeGCRule(datetime.timedelta(days=1))


column_families = {'location': max_age_rule}
if not table.exists():
    table.create(column_families=column_families)
    print("Table Created")
else:
    print("Table {} already exists.".format(table_id))


# In[13]:


byte_data=struct.pack('>d', 0.75)


# In[14]:


print('Writing some gvalues to the table.')
column_family_id='location'
rows = []

for i in range(10000):
    row_key = 'Location{}'.format(i).encode()
    long=df['Longitude'][i]
    lat=df['Latitude'][i]
    row = table.direct_row(row_key)
    long_data=struct.pack('>d', long)
    lat_data=struct.pack('>d', lat)
    row.set_cell(column_family_id,
                 'Longitude',
                 long_data,
                 timestamp=datetime.datetime.utcnow())
    row.set_cell(column_family_id,
                 'Latitude',
                 lat_data,
                 timestamp=datetime.datetime.utcnow())
    rows.append(row)
    print('Successfully wrote row {}.'.format(row_key))
table.mutate_rows(rows)


# In[15]:


# $:cbt listinstances
# $:cbt -instance accidentdb count accident

