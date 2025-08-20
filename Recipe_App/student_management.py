import os

FILENAME = "students.txt"

def add_student():
    with open(FILENAME, "a") as f:
        roll = input("Enter Roll Number: ")
        name = input("Enter Name: ")
        marks = input("Enter Marks: ")
        f.write(f"{roll},{name},{marks}\n")
    print("Student added successfully!\n")

def display_students():
    print("\n--- Student Records ---")
    try:
        with open(FILENAME, "r") as f:
            for line in f:
                roll, name, marks = line.strip().split(",")
                print(f"Roll: {roll}, Name: {name}, Marks: {marks}")
    except FileNotFoundError:
        print("No records found.")
    print()

def search_student():
    roll_no = input("Enter Roll Number to Search: ")
    found = False
    try:
        with open(FILENAME, "r") as f:
            for line in f:
                roll, name, marks = line.strip().split(",")
                if roll == roll_no:
                    print(f"Record Found: Roll: {roll}, Name: {name}, Marks: {marks}")
                    found = True
                    break
        if not found:
            print("Student not found.\n")
    except FileNotFoundError:
        print("No records found.\n")

def update_student():
    roll_no = input("Enter Roll Number to Update: ")
    updated = False
    try:
        lines = []
        with open(FILENAME, "r") as f:
            lines = f.readlines()
        with open(FILENAME, "w") as f:
            for line in lines:
                roll, name, marks = line.strip().split(",")
                if roll == roll_no:
                    print("Enter new details:")
                    name = input("New Name: ")
                    marks = input("New Marks: ")
                    f.write(f"{roll},{name},{marks}\n")
                    updated = True
                else:
                    f.write(line)
        if updated:
            print("Student record updated.\n")
        else:
            print("Student not found.\n")
    except FileNotFoundError:
        print("No records found.\n")

def delete_student():
    roll_no = input("Enter Roll Number to Delete: ")
    deleted = False
    try:
        lines = []
        with open(FILENAME, "r") as f:
            lines = f.readlines()
        with open(FILENAME, "w") as f:
            for line in lines:
                roll, name, marks = line.strip().split(",")
                if roll != roll_no:
                    f.write(line)
                else:
                    deleted = True
        if deleted:
            print("Student record deleted.\n")
        else:
            print("Student not found.\n")
    except FileNotFoundError:
        print("No records found.\n")

def menu():
    while True:
        print("\n==== Student Record Management ====")
        print("1. Add Student")
        print("2. Display All Students")
        print("3. Search Student")
        print("4. Update Student")
        print("5. Delete Student")
        print("6. Exit")
        choice = input("Enter your choice: ")

        if choice == '1':
            add_student()
        elif choice == '2':
            display_students()
        elif choice == '3':
            search_student()
        elif choice == '4':
            update_student()
        elif choice == '5':
            delete_student()
        elif choice == '6':
            print("Exiting program.")
            break
        else:
            print("Invalid choice! Please try again.")

# Run the program
menu()
