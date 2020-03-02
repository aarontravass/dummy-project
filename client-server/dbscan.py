
# coding: utf-8

# In[1]:


import struct
from google.cloud import bigtable
from google.cloud.bigtable import column_family
from google.cloud.bigtable import row_filters
import matplotlib.pyplot as plt
from sklearn.cluster import DBSCAN
import sklearn.utils
from sklearn.preprocessing import StandardScaler
import numpy as np
import mysql.connector


# In[2]:





# In[2]:


from google.oauth2 import service_account

credentials = service_account.Credentials.from_service_account_file(
    'sih.json')

scoped_credentials = credentials.with_scopes(
    ['https://www.googleapis.com/auth/cloud-platform'])


# In[87]:


project_id='' 
instance_id='accidentdb'
table_id='accident'


# In[88]:


client = bigtable.Client(project=project_id, admin=True,credentials=credentials)
instance = client.instance(instance_id)
row_filter = row_filters.CellsColumnLimitFilter(1)
table = instance.table(table_id)
column_family_id='location'
partial_rows = table.read_rows(filter_=row_filter)
lc=[]



# In[89]:


print('Scanning for all rows:')
for row in partial_rows:
    loc = row.cells[column_family_id]
    lng=loc[b'Longitude'][0]
    lt=loc[b'Latitude'][0]
    valy=struct.unpack('>d',lng.value)[0]
    valx=struct.unpack('>d',lt.value)[0]
    lc.append([valx,valy])


# In[90]:

"""
plt.scatter(x,y)
plt.xlabel('Latitude')
plt.ylabel('Longitude')
plt.show()"""


# In[91]:


X=StandardScaler().fit_transform(lc)


# In[92]:


kms_per_radian = 6371.0088
epsilon = 0.7 / kms_per_radian
db = DBSCAN(eps=epsilon, min_samples=1, algorithm='ball_tree', metric='haversine').fit(np.radians(lc))
labs=db.labels_
n_clusters_ = len(set(labs)) - (1 if -1 in labs else 0)
n_noise_ = list(labs).count(-1)


# In[93]:


print(len(labs))


# In[94]:


un=set(labs)
core_samples_mask = np.zeros_like(db.labels_, dtype=bool)
core_samples_mask[db.core_sample_indices_] = True
colors = [plt.cm.Spectral(each) for each in np.linspace(0, 1, len(un))]


# In[95]:
"""

for k, col in zip(un, colors):
    if k == -1:
        # Black used for noise.
        col = [0, 0, 0, 1]

    class_member_mask = (labs == k)

    xy = X[class_member_mask & core_samples_mask]
    plt.plot(xy[:, 0], xy[:, 1], 'o', markerfacecolor=tuple(col),
             markeredgecolor='k', markersize=14)

    xy = X[class_member_mask & ~core_samples_mask]
    plt.plot(xy[:, 0], xy[:, 1], 'o', markerfacecolor=tuple(col),
             markeredgecolor='k', markersize=6)

plt.title('Estimated number of clusters: %d' % n_clusters_)
plt.xlabel('Latitude')
plt.ylabel('Longitude')
plt.show()
"""

# In[99]:


centers={}
row_filter = row_filters.CellsColumnLimitFilter(1)
print('Scanning for all rows:')
partial_rows = table.read_rows(filter_=row_filter)
i=0
for row in partial_rows:
    loc = row.cells[column_family_id]
    lng=loc[b'Longitude'][0]
    lt=loc[b'Latitude'][0]
    valy=struct.unpack('>d',lng.value)[0]
    valx=struct.unpack('>d',lt.value)[0]
    try:
        co=centers[labs[i]]
        centers[labs[i]]=((co[0]+valx)/2,(co[1]+valy)/2,co[2]+1)
    except:
        if(labs[i]!=-1):
            centers[labs[i]]=(valx,valy,1)
    i+=1
        
    


# In[100]:


print(centers)


# In[101]:


conn=mysql.connector.connect(host="",user="",passwd="",database="means")
print(conn)
mycursor=conn.cursor()
for i in un:
    if(i!=-1):
        sql="insert into meandb values(null,%s,%s,%s);"
        val=(centers[i][0],centers[i][1],centers[i][2])
        mycursor.execute(sql,val)
conn.commit()

