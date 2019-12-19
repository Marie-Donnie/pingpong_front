from tkinter import *
from Client import Client

root = Tk()
root.geometry("750x750")

fup = Frame(root)
fup.pack(side=TOP)
titre=Label(fup,text="Ping Athena",font=("Times",20,"bold"))
titre.pack(side=TOP)
# img=PhotoImage(file="./network.png")
# image=Label(fup,image=img)
# image.pack(side=BOTTOM,pady=30)

fdown=Frame(root)
fdown.pack(side=BOTTOM)
button=Button(fdown,text="Launch traceroutes",command=Client().run)
button.pack(side=BOTTOM)

root.mainloop()