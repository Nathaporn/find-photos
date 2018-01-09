import numpy as np
import cv2
import os
import glob
import sys

def saveFace(path):
    for filename in glob.glob(path + '/train/*.jpg'): # training
        #print(filename)
        image = cv2.imread(filename)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        face_cascade = cv2.CascadeClassifier('../app/python/haarcascade_frontalface_default.xml')
        faces = face_cascade.detectMultiScale(gray, 1.3, 5)
        i = len(glob.glob1(path + '/found/*.jpg',"*.jpg"))
        for (x,y,w,h) in faces:
            cv2.rectangle(image,(x,y),(x+w,y+h),(255,0,0),0)
            roi_gray = gray[y:y+h, x:x+w]
            roi_rgb = image[y:y+h, x:x+w]
            # print (type(roi_gray))
            cv2.imwrite("%s/found/%d.jpg" % (path,i) ,roi_rgb)
            i+=1
           #roi_color = image[y:y+h, x:x+w]
            # cv2.imshow('img',cv2.resize(roi_gray, (100, 100)))
            # cv2.waitKey(0)
            # cv2.destroyAllWindows()

if __name__ == "__main__":
    # print(os.getcwd())

    uid = sys.argv[1]
    tid = sys.argv[2]
    saveFace("%s/users/%s/uploads/%s/" % (os.getcwd(),uid,tid))
    print("finish")
