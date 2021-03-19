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

fname = sys.argv[1]
with open(fname,'r') as file:
    file_read=csv.reader(file)


    # Use column 1(patient_id), 2(sex), 3(age), 4(country), 5(province), 6(city), 7(infection_case), 8(infected_by), 9(contact_number)
    #           10(symptom_onset_date),11(confirmed_date), 12(released_date),13(deceased_date), 14(state)
    # index = column - 1
    col_list = { 
        'region_code' :23,
        'province' :4,
        'city' : 5,
        'latitude' : 24,
        'longtitude' : 25,
        'elementary_school_count' :26,
        'kindergarten_count' : 27,
        'university_count' : 28,
        'academy_ratio' : 29,
        'elderly_population_ratio' : 30,
        'elderly_alone_ratio' : 31,
        'nursing_home_count' : 32}

    for i,line in enumerate(file_read):

        #Skip first line
        if not i:                           
            continue

        # checking duplicate region_code & checking region_code == "NULL"
        if (line[col_list['region_code']] in patient_id ) or (line[col_list['region_code']] == "NULL") :
            continue
        else:
            patient_id.append(line[col_list['region_code']])

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
        query = """INSERT INTO `Region`(region_code,province,city,latitude,longtitude,elementary_school_count,kindergarten_count,university_count,academy_ratio,elderly_population_ratio,elderly_alone_ratio,nursing_home_count) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)
        #print(sql_data)
        #for debug
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to region"%(line[col_list['region_code']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['region_code']],e))
            break

conn.commit()
cursor.close()
