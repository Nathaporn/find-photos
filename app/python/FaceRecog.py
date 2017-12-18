import numpy as np
import cv2
import os
import glob

# face_cascade = cv2.CascadeClassifier('./haarcascade_frontalface_default.xml')
# eye_cascade = cv2.CascadeClassifier('haarcascade_eye.xml')
# img = cv2.imread('S.jpg')
# gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
#
# faces = face_cascade.detectMultiScale(gray, 1.3, 5)
# for (x,y,w,h) in faces:
#     cv2.rectangle(img,(x,y),(x+w,y+h),(255,0,0),2)
#     roi_gray = gray[y:y+h, x:x+w]
#     roi_color = img[y:y+h, x:x+w]
#     #eyes = eye_cascade.detectMultiScale(roi_gray)
#     #for (ex,ey,ew,eh) in eyes:
#         #cv2.rectangle(roi_color,(ex,ey),(ex+ew,ey+eh),(0,255,0),2)
# cv2.imshow('img',img)
# cv2.waitKey(0)
# cv2.destroyAllWindows()
#for filename in os.listdir(os.getcwd()):
    #print (filename)

#for filename in glob.glob(os.path.join(os.getcwd(), '*.jpg')):
    #print (filename)

def saveFace(path):
    for filename in glob.glob(path + '/trainingImage/*.jpg'): # training
        image = cv2.imread(filename)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        face_cascade = cv2.CascadeClassifier('./haarcascade_frontalface_default.xml')
        faces = face_cascade.detectMultiScale(gray, 1.3, 5)
        i = 0
        for (x,y,w,h) in faces:
            cv2.rectangle(image,(x,y),(x+w,y+h),(255,0,0),2)
            roi_gray = gray[y:y+h, x:x+w]
            print (type(roi_gray))
            cv2.imwrite("%s/trainingImage/onlyFace/%d.jpg" % (path,i) ,roi_gray)
            i+=1
           #roi_color = image[y:y+h, x:x+w]
            cv2.imshow('img',cv2.resize(roi_gray, (100, 100)))
            cv2.waitKey(0)
            cv2.destroyAllWindows()


#def trainingImage(path):
    #faceArray = []
    #labels = []
    #for filename in glob.glob(path + '*.jpg'): # training
        #image = cv2.imread(filename)
        #gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        #face_cascade = cv2.CascadeClassifier('./haarcascade_frontalface_default.xml')
        #face_recognizer = cv2.face.LBPHFaceRecognizer_create(1,8,8,8,100)
        #faces = face_cascade.detectMultiScale(gray, 1.3, 5)
        #i = 0
        #for (x,y,w,h) in faces:
            #cv2.rectangle(image,(x,y),(x+w,y+h),(255,0,0),2)
            #roi_gray = gray[y:y+h, x:x+w]
            #print (type(roi_gray))
            #cv2.imwrite("%s/trainingImage/%d.jpg" % (path,i) ,cv2.resize(roi_gray, (100, 100)))
            #i+=1
            #faceArray.append(cv2.resize(roi_gray, (100, 100)))
            #labels.append(2)
            #cv2.imshow('img',cv2.resize(roi_gray, (100, 100)))
            #cv2.waitKey(0)
            #cv2.destroyAllWindows()

    #face_recognizer.train(faceArray, np.array(labels))
    #face_recognizer.write("%s/test.yml" % path)

def trainingImage(path):
    faceArray = []
    labels = []
    for filename in glob.glob(path+'/trainingImage/onlyFace/*.jpg'): # training
        print (filename)
        face_recognizer = cv2.face.LBPHFaceRecognizer_create(1,8,8,8,100)
        image = cv2.imread(filename)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        faceArray.append(cv2.resize(gray, (100, 100)))
        labels.append(2)
    face_recognizer.train(faceArray, np.array(labels))
    face_recognizer.write("%s/trainingImage/test.yml" % path)

def predictFace(path):
    face_recognizer = cv2.face.LBPHFaceRecognizer_create(1,8,8,8,100)
    face_recognizer.read(path + "/trainingImage/test.yml")
    face_cascade = cv2.CascadeClassifier('./haarcascade_frontalface_default.xml')
    for filename in glob.glob(path + '/predictImage/*.jpg'): # training
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

def feedback():
    print ("hello")

if __name__ == "__main__":
    path = "./"
    saveFace(path)
    trainingImage(path)
    predictFace(path)
