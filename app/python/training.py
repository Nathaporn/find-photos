import numpy as np
import cv2
import os
import glob
import sys

def trainingImage(path):
    faceArray = []
    labels = []
    # print(path)
    for filename in glob.glob(path+'/train/*.jpg'): # training
        # print (filename)
        face_recognizer = cv2.face.LBPHFaceRecognizer_create(1,8,8,8,100)
        image = cv2.imread(filename)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        faceArray.append(cv2.resize(gray, (100, 100)))
        labels.append(2)
    face_recognizer.train(faceArray, np.array(labels))
    face_recognizer.write("%s/train/train.yml" % path)

if __name__ == "__main__":
    # uid = sys.argv[1]
    tid = sys.argv[1]


    trainingImage("%s/targets/%s/" % (os.getcwd(),tid))
    print("finish")
