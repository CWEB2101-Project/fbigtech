import tkinter as tk
from subprocess import Popen

root = tk.Tk()

def open_prog2():
    Popen("program2.exe")

button = tk.Button(root, text="Open Program 2", command=open_prog2)
button.pack()

def open_prog3():
    Popen("program3.exe")

button = tk.Button(root, text="Open Program 3", command=open_prog3)
button.pack()

def open_prog4():
    Popen("program4.exe")

button = tk.Button(root, text="Open Program 4", command=open_prog4)
button.pack()

def open_prog5():
    Popen("program5.exe")

button = tk.Button(root, text="Open Program 5", command=open_prog5)
button.pack()

def open_prog6():
    Popen("program6.exe")

button = tk.Button(root, text="Open Program 6", command=open_prog6)
button.pack()

def open_prog7():
    Popen("program7.exe")

button = tk.Button(root, text="Open Program 7", command=open_prog7)
button.pack()

def open_prog8():
    Popen("program8.exe")

button = tk.Button(root, text="Open Program 8", command=open_prog8)
button.pack()

root.mainloop()