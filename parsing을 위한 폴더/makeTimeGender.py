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


fname1 = sys.argv[1]
with open(fname1,'r') as file:
    data = pd.read_csv(file)


# Using Hashing

# 2000-10-11 male 10 1
# 2000-10-11 man 13 3

# get confirmed_date from "K_COVID19.csv" and count
#날짜 별 사람 수 누적
confirmed_date = data['confirmed_date']
male_cdate_dic = {}
female_cdate_dic = {}

deceased_date = data['deceased_date']
male_ddate_dic = {}
female_ddate_dic = {}

sex = data['sex']
#성별에 따라 confirmed date를 ++해준다
i=0
for word in list(sex):
    if word=='male':
        if confirmed_date[i] in male_cdate_dic.keys():
            male_cdate_dic[confirmed_date[i]] = male_cdate_dic[confirmed_date[i]] + 1
        else:
            male_cdate_dic[confirmed_date[i]] = 1
    elif word=='female':
        if confirmed_date[i] in female_cdate_dic.keys():
            female_cdate_dic[confirmed_date[i]] = female_cdate_dic[confirmed_date[i]] + 1
        else:
            female_cdate_dic[confirmed_date[i]] = 1
    i=i+1
#성별에 따라 deceased date를 ++해준다
i=0
for word in list(sex):
    if word=='male':
        if deceased_date[i] in male_ddate_dic.keys():
            male_ddate_dic[deceased_date[i]] = male_ddate_dic[deceased_date[i]] + 1
        else:
            male_ddate_dic[deceased_date[i]] = 1
    elif word=='female':
        if deceased_date[i] in female_ddate_dic.keys():
            female_ddate_dic[deceased_date[i]] = female_ddate_dic[deceased_date[i]] + 1
        else:
            female_ddate_dic[deceased_date[i]] = 1
    i=i+1


# 중복된 case 제거를 위해 checking list & variable
date = []
male_total_confirmed = 0
female_total_confirmed = 0
a = "male"
b = "female"
male_total_deceased = 0
female_total_deceased = 0

fname2 = sys.argv[2]#file2는 addtional
with open(fname2,'r') as file:
    file_read = csv.reader(file)

    # Use column 1(date), 2(test), 3(negative)
    # index = column - 1
    col_list = {
        'date' :0
    }

    for i,line in enumerate(file_read):

        #Skip first line
        #Skip first line
        if not i:
            continue

        # checking duplicate case_id & checking case_id == "NULL"
        if (line[col_list['date']] in date) or (line[col_list['date']] == "NULL") :
            continue
        else:
            date.append(line[col_list['date']])

        #make sql data & query
        sql_data = []
        #"NULL" -> None (String -> null)
        for idx in col_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            sql_data.append(line[idx])


        sql_data2 = []
        #"NULL" -> None (String -> null)
        for idx in col_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            sql_data2.append(line[idx])
        

        

        # append "total number from sex" to sql_date list
        sql_data.append(a)
        # append "total number from confirmed_date" to sql_date list
        if line[col_list['date']] in male_cdate_dic.keys():
            male_total_confirmed = male_total_confirmed + male_cdate_dic[line[col_list['date']]]
        sql_data.append(male_total_confirmed)
        if line[col_list['date']] in male_ddate_dic.keys():
            male_total_deceased = male_total_deceased + male_ddate_dic[line[col_list['date']]]
        sql_data.append(male_total_deceased)





        sql_data2.append(b)
        if line[col_list['date']] in female_cdate_dic.keys():
            female_total_confirmed = female_total_confirmed + female_cdate_dic[line[col_list['date']]]
        sql_data2.append(female_total_confirmed)
        # append "total number from deceased_date" to sql_date list
        if line[col_list['date']] in female_ddate_dic.keys():
            female_total_deceased = female_total_deceased + female_ddate_dic[line[col_list['date']]]
        sql_data2.append(female_total_deceased)
        
    





        #Make query & execute
        query = """INSERT INTO `timegender`(date, sex, confirmed, deceased) VALUES (%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)
        sql_data2 = tuple(sql_data2)

        #for debug
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to timeGender"%(line[col_list['date']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['date']],e))
            break

        try:
            cursor.execute(query, sql_data2)
            print("[OK] Inserting [%s] to timeGender"%(line[col_list['date']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['date']],e))
            break

conn.commit()
cursor.close()