# -*- coding: utf-8 -*-
import pymysql
import csv
import sys
import pandas as pd
from scipy.spatial import distance
import operator

def euclidean_distance(pt1, pt2):
  distance = 0.0
  for i in range(len(pt1)):
    distance += (pt1[i] - pt2[i]) ** 2
  return distance ** 0.5


#mysql server 연결, port 및 host 주의!
conn = pymysql.connect(host='localhost',
                        port = 3306,
                        user='root',
                        password='Eh4693227!',
                        db='K_COVID19',
                        charset='utf8')

# Connection 으로부터 Cursor 생성
cursor = conn.cursor()


#43개의 병원 데이터 저장
Hospital_id = []
hospital_data = []
fname1=sys.argv[1]
with open(fname1,'r',encoding='UTF8') as file:
    file_read = csv.reader(file)

    hospital_list = {
        'Hospital_id' :0,
        'latitude' : 4,
        'longitude' :5,
        'capacity' : 6,
        'now' : 7}

    for i,line in enumerate(file_read):
        #Skip first line
        if not i:
            continue

        if (line[hospital_list['Hospital_id']] in Hospital_id) or (line[hospital_list['Hospital_id']] == "NULL") :
            continue
        else:
            Hospital_id.append(line[hospital_list['Hospital_id']])

        # make data
        h_data = []
        #"NULL" -> None (String -> null)
        for idx in hospital_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            h_data.append(line[idx])
        hospital_data.append(h_data)
#print(h_data)

# 중복된 case 제거를 위해 checking list
region_code = []
region_data = []
fname2=sys.argv[2]
with open(fname2, 'r') as file:
    file_read = csv.reader(file)


    region_list = {
        'region_code': 0,
        'province': 1,
        'city': 2,
        'latitude': 3,
        'longtitude': 4
    }


    for i,line in enumerate(file_read):

        #Skip first line
        if not i:
            continue

        if (line[region_list['region_code']] in region_code) or (line[region_list['region_code']] == "NULL") :
            continue
        else:
            region_code.append(line[region_list['region_code']])

        # make data
        r_data = []

        #"NULL" -> None (String -> null)
        for idx in region_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            r_data.append(line[idx])
        region_data.append(r_data)
#print(r_data)
#print(region_data)

sql_data = []
sql_f = [] #patentinfo에 hospital_id업데이트 해주기위함 (hospital_id, patient_id)리스트가 리스트에 담김
patient_id = []
patient_data = []
fname3 = sys.argv[3]
with open(fname3, 'r') as file:
    file_read = csv.reader(file)

    patientinfo_list = {
        'patient_id': 0,
        'region_code': 23,
        'province': 4,
        'city': 5
        }

    for i, line in enumerate(file_read):
        # Skip first line
        if not i:
            continue
        # checking duplicate patient_id & checking patient_id == "NULL"
        if (line[patientinfo_list['patient_id']] in patient_id) or (line[patientinfo_list['patient_id']] == "NULL"):
            continue
        else:
            patient_id.append(line[patientinfo_list['patient_id']])

        # make data
        p_data = []
        #"NULL" -> None (String -> null)
        for idx in patientinfo_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            p_data.append(line[idx])

        #patient_data.append(p_data)
#print(p_data)
        if p_data[3] == "etc":
            for region in region_data:
                if p_data[2]==region[1]:
                    p_latitude = region[3]
                    p_longtitude = region[4]
        else :
            for region in region_data:
                if p_data[1] == region[0]:#compare region code
                    p_latitude = region[3]
                    p_longtitude = region[4]

        num = {} #43개의 병원에대한 거리 값이 저장될 배열

        #euclidean_distance([5, 4, 3], [1, 7, 9])

        for h,hospital in enumerate(hospital_data):
            num[hospital[0]] = euclidean_distance([float(p_latitude), float(p_longtitude)],[float(hospital[1]),float(hospital[2])])

        sorted_num = sorted(num.items(), key=operator.itemgetter(1))

        for sn in sorted_num:
            num = 0
            for hospital in  hospital_data:
                if sn[0] == hospital[0]:
                    if int(hospital[3])>int(hospital[4]):
                        hospital[4] = int(hospital[4])+1
                        patientinfo_hospital_id = hospital[0]
                        p_data.append(patientinfo_hospital_id)#읽어드린 patient 정보에 병원정보를 붙여준다
                        
                        #print(p_data)
                        num=1
                        break
            if num==1:
                break
                
        sql_data.append(p_data)
        
for i, v in enumerate(sql_data):
    sql_f.append([sql_data[i][4],sql_data[i][0]])
     

#print(sql_f)
#print(hospital_data)


for i, v in enumerate(sql_f):
    query = """UPDATE patientinfo SET hospital_id=%s WHERE patient_id=%s"""
    try:
        cursor.execute(query, (sql_f[i][0],sql_f[i][1]))
        print("[OK] Update [%s] to hospital"%(sql_f[i][1]))
    except (pymysql.Error, pymysql.Warning) as e :
        # print("[Error]  %s"%(pymysql.IntegrityError))
        if e.args[0] == 1062: continue
        print('[Error] %s | %s'%(sql_f[i][1],e))
        break

sql_n = []
for i, v in enumerate(hospital_data):
    sql_n.append([hospital_data[i][4],hospital_data[i][0]])

for i, v in enumerate(sql_n):
    query = """UPDATE hospital SET now=%s WHERE hospital_id=%s"""
    try:
        cursor.execute(query, (sql_n[i][0],sql_n[i][1]))
        print("[OK] Update [%s] to hospital_now"%(sql_n[i][1]))
    except (pymysql.Error, pymysql.Warning) as e :
        # print("[Error]  %s"%(pymysql.IntegrityError))
        if e.args[0] == 1062: continue
        print('[Error] %s | %s'%(sql_f[i][1],e))
        break



conn.commit()
cursor.close()
