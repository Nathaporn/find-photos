import numpy as np
import cv2
import os
import glob
import sys
import urllib.request
import csv


def predictSiam2nite(path,csvName,resultCSV):

    '''
    resp = urllib.request.urlopen("https://d136usn7jnoe61.cloudfront.net/pictures/18859/s2n_0191_p1bdr07kctvb3g6815uid9627k64.jpg")
    image = np.asarray(bytearray(resp.read()), dtype="uint8")
    image = cv2.imdecode(image, cv2.IMREAD_COLOR)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    cv2.imshow('img',gray)
    cv2.waitKey(0)
    cv2.destroyAllWindows()
    '''
    i = 0
    with open('./csv/'+csvName) as csvfile:
        reader = csv.DictReader(csvfile)
        with open(path+'/result/'+resultCSV+".csv", 'w') as csvfile:
                fieldnames = ['url_result']
                writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
                writer.writeheader()
                for row in reader:
                    url = row['imagePath']
            # print(url)
                    if(url == "imagePath" or url == " " or url == ""):
                        continue
                    resp = urllib.request.urlopen(url)
                    image = np.asarray(bytearray(resp.read()), dtype="uint8")
                    image = cv2.imdecode(image, cv2.IMREAD_COLOR)
                    face_recognizer = cv2.face.LBPHFaceRecognizer_create(1,8,8,8,100)
                    face_recognizer.read(path + "/train/train.yml")
                    face_cascade = cv2.CascadeClassifier('../app/python/haarcascade_frontalface_default.xml')
                    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
                    faces = face_cascade.detectMultiScale(gray, 1.3, 5)
                    for (x,y,w,h) in faces:
                        cv2.rectangle(image,(x,y),(x+w,y+h),(255,0,0),2)
                        roi_gray = gray[y:y+h, x:x+w]
                        result = face_recognizer.predict(cv2.resize(roi_gray, (100, 100)))
                        if(result[0] == 2):
                            writer.writerow({'url_result': url})
                    # cv2.imshow(str(i),cv2.resize(roi_gray, (100, 100)))
                    # cv2.waitKey(0)
                    # cv2.destroyAllWindows()
                            i+=1
                            break
    print(i)
        # cv2.imshow('img',image)

'''
for filename in glob.glob(path + 'testImage/*.jpg'): # training
    image = cv2.imread(filename)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    faces = face_cascade.detectMultiScale(gray, 1.3, 5)
    for (x,y,w,h) in faces:
        cv2.rectangle(image,(x,y),(x+w,y+h),(255,0,0),2)
        roi_gray = gray[y:y+h, x:x+w]
        result = face_recognizer.predict(cv2.resize(roi_gray, (100, 100)))
        if(result[0] == 2):
            cv2.imshow('img',cv2.resize(roi_gray, (100, 100)))
            cv2.waitKey(0)
            cv2.destroyAllWindows()
'''

if __name__ == "__main__":
    uid = sys.argv[1]
    tid = sys.argv[2]
    csvName = sys.argv[3]
    resultCSV = sys.argv[4]
    predictSiam2nite("%s/users/%s/targets/%s/" % (os.getcwd(),uid,tid),csvName,resultCSV)
