# -*- coding: utf-8 -*- 
import pymysql
import csv
import pandas as pd
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

kname=sys.argv[1]
data = pd.read_csv(kname)

# province
place = data['province']
confirmed_date = data['confirmed_date']
released_date = data['released_date']
deceased_date = data['deceased_date']
p_dic = {}

for p in list(place):
    if p in p_dic.keys():
        continue
    else:
        p_dic[p] = []


for p in p_dic.keys():

    cdate_dic = {}
    for i, date in enumerate(list(confirmed_date)):
        if place[i] != p:
            continue
        if date in cdate_dic.keys():
            cdate_dic[date] = cdate_dic[date] + 1
        else:
            cdate_dic[date] = 1
        
    rdate_dic = {}
    for i, date in enumerate(list(released_date)):
        if place[i] != p:
            continue
        if date in rdate_dic.keys():
            rdate_dic[date] = rdate_dic[date] + 1
        else:
            rdate_dic[date] = 1

    ddate_dic = {}
    for i, date in enumerate(list(deceased_date)):
        if place[i] != p:
            continue
        if date in ddate_dic.keys():
            ddate_dic[date] = ddate_dic[date] +1
        else:
            ddate_dic[date] = 1

    p_dic[p].append(cdate_dic)
    p_dic[p].append(rdate_dic)
    p_dic[p].append(ddate_dic)


# 중복된 case 제거를 위해 checking list & variable
date = []
total_confirmed = []
total_released = []
total_deceased = []
i=0
for p in p_dic.keys():
    total_confirmed.insert(i, 0)
    total_released.insert(i,0)
    total_deceased.insert(i,0)
    i=i+1



aname = sys.argv[2]
with open(aname, 'r') as file:
    file_read = csv.reader(file)

    # Use column 1(date), 2(test), 3(negative)
    # index = column - 1
    col_list = { 
        'date' :0}

    for i,line in enumerate(file_read):

        #Skip first line
        if not i:                           
            continue

        # checking duplicate case_id & checking case_id == "NULL"
        if (line[col_list['date']] in date) or (line[col_list['date']] == "NULL") :
            continue
        else:
            date.append(line[col_list['date']])

        #make sql data & query
        op = 0
    

        for p in p_dic.keys():

            sql_data = []

            sql_data.append(line[col_list['date']])
            
            sql_data.append(p)

            # append "total number from confirmed_date" to sql_date list
            if line[col_list['date']] in p_dic[p][0].keys():
                total_confirmed[op] = total_confirmed[op] + p_dic[p][0][line[col_list['date']]]
            sql_data.append(total_confirmed[op])
            # append "total number from released_date" to sql_date list
            if line[col_list['date']] in p_dic[p][1].keys():
                total_released[op] = total_released[op] + p_dic[p][1][line[col_list['date']]]
            sql_data.append(total_released[op])
            # append "total number from deceased_date" to sql_date list
            if line[col_list['date']] in p_dic[p][2].keys():
                total_deceased[op] = total_deceased[op] + p_dic[p][2][line[col_list['date']]]
            sql_data.append(total_deceased[op])
            op = op + 1
    





            #Make query & execute
            query = """INSERT INTO `TIMEPROVINCE`(date, province, confirmed, released, deceased) VALUES (%s,%s,%s,%s,%s)"""
            sql_data = tuple(sql_data)

            #for debug
            try:
                cursor.execute(query, sql_data)
                print("[OK] Inserting [%s] to TIMEPROVINCE"%(line[col_list['date']]))
            except (pymysql.Error, pymysql.Warning) as e :
                # print("[Error]  %s"%(pymysql.IntegrityError))
                if e.args[0] == 1062: continue
                print('[Error] %s | %s'%(line[col_list['date']],e))
                break

conn.commit()
cursor.close()