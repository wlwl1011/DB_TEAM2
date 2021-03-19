# -*- coding: utf-8 -*- 
import pymysql
import csv
import sys

#mysql server 연결, port 및 host 주의!
conn = pymysql.connect(host='localhost',
                        port = 3306,
                        user='root', 
                        password='Eh4693227!',
                        db='K_COVID19', 
                        charset='utf8')

# Connection 으로부터 Cursor 생성
cursor = conn.cursor()

# 중복된 case 제거를 위해 checking list
patient_id = []
fname=sys.argv[1]
with open(fname, 'r',encoding = 'UTF8') as file:
    file_read = csv.reader(file)

    # Use column 1(patient_id), 2(sex), 3(age), 4(country), 5(province), 6(city), 7(infection_case), 8(infected_by), 9(contact_number)
    #           10(symptom_onset_date),11(confirmed_date), 12(released_date),13(deceased_date), 14(state)
    # index = column - 1
    col_list = { 
        'Hospital_id' :0,
        'province' : 2,
        'city' : 3,
        'latitude' : 4,
        'longitude' :5,
        'capacity' : 6,
        'now' : 7}

    for i,line in enumerate(file_read):

        #Skip first line
        if not i:                           
            continue

        if (line[col_list['Hospital_id']] in patient_id) or (line[col_list['Hospital_id']] == "NULL") :
            continue
        else:
            patient_id.append(line[col_list['Hospital_id']])

        #make sql data & query
        sql_data = []
        print(line)
        #"NULL" -> None (String -> null)
        print(col_list.values())
        for idx in col_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            sql_data.append(line[idx])
        print(sql_data)
        query = """INSERT INTO `Hospital`(Hospital_id,province,city,latitude,longitude,capacity,now) VALUES (%s,%s,%s,%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)
        #print(sql_data)
        #for debug
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to Hospital"%(line[col_list['Hospital_id']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['Hospital_id']],e))
            break

conn.commit()
cursor.close()

print(len(patient_id))
