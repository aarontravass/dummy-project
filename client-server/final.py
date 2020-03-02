import os
import sys
import json
import mysql.connector
import geocoder
import googlemaps

g = geocoder.ip('me').latlng
#"57.8765","1.98765"



def hos():
    places = gmaps.places_nearby(location=(co[0], co[1]), rank_by='distance', type='hospital', name='Hospital',
                                 language='en')
    print(places['results'][0]['plus_code']['global_code'])
    hospital=[]
    for i in range(len(places['results'])):
        t = places['results'][i]['name']
        if ('hospital' in t.lower()):
            hospital.append([t, places['results'][i]['id']])
    return hospital


def pol(co):
    places = gmaps.places_nearby(location=(co[0],co[1]), rank_by='distance', type='police', name='police',
                                 language='en')
    #print(places['results'][0])
    police=[]
    for i in range(len(places['results'])):
        t = places['results'][i]['name']
        if ('police' in t.lower()):
            police.append([t, places['results'][i]['id']])
    return police


def firest():
    places = gmaps.places_nearby(location=(co[0], co[1]), rank_by='distance', type='police', name='police',
                                 language='en')
    print(places['results'][0])
    fire=[]
    for i in range(len(places['results'])):
        t = places['results'][i]['name']
        if ('fire' in t.lower()):
            fire.append([t, places['results'][i]['id']])
    return fire


run=True
while(run):
     files=os.listdir('/media/data/')
     if(len(files)==0):
          
          continue
     else:
        current=files[0]
        with open('/media/data/'+current,"r") as f:
           temp = json.load(f)
        print(temp)
        co=(temp['0'],temp['1'])
        api_key=""
        gmaps = googlemaps.Client(key=api_key)
        print(co)
        police=pol(co)
        conn=mysql.connector.connect(host="",user="",passwd="",database="temp")
        print(conn)
        mycursor=conn.cursor()
        for i in range(len(police)):
            sql="insert into temptable values(null,%s,%s);"
            val=(police[i][1],temp['2'])
            mycursor.execute(sql, val)


        val=("teh",temp['2'])
        mycursor.execute(sql, val)
        conn.commit()
        os.remove('/media/data/'  + current)
        