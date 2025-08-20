#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct Student {
    int roll;
    char name[50];
    float marks;
};

void addStudent() {
    FILE *fptr = fopen("students.txt", "a");
    struct Student s;

    printf("Enter Roll No: ");
    scanf("%d", &s.roll);
    printf("Enter Name: ");
    scanf(" %[^\n]", s.name);
    printf("Enter Marks: ");
    scanf("%f", &s.marks);

    fprintf(fptr, "%d,%s,%.2f\n", s.roll, s.name, s.marks);
    fclose(fptr);

    printf("Student added successfully!\n");
}

void displayStudents() {
    FILE *fptr = fopen("students.txt", "r");
    struct Student s;

    if (fptr == NULL) {
        printf("No records found.\n");
        return;
    }

    printf("\n--- Student Records ---\n");
    while (fscanf(fptr, "%d,%49[^,],%f\n", &s.roll, s.name, &s.marks) != EOF) {
        printf("Roll: %d, Name: %s, Marks: %.2f\n", s.roll, s.name, s.marks);
    }

    fclose(fptr);
}

void searchStudent() {
    int rollNo, found = 0;
    struct Student s;
    FILE *fptr = fopen("students.txt", "r");

    if (fptr == NULL) {
        printf("No records found.\n");
        return;
    }

    printf("Enter Roll Number to search: ");
    scanf("%d", &rollNo);

    while (fscanf(fptr, "%d,%49[^,],%f\n", &s.roll, s.name, &s.marks) != EOF) {
        if (s.roll == rollNo) {
            printf("Record Found: Roll: %d, Name: %s, Marks: %.2f\n", s.roll, s.name, s.marks);
            found = 1;
            break;
        }
    }

    if (!found) {
        printf("Student not found.\n");
    }

    fclose(fptr);
}

void deleteStudent() {
    int rollNo, found = 0;
    struct Student s;
    FILE *fptr = fopen("students.txt", "r");
    FILE *temp = fopen("temp.txt", "w");

    if (fptr == NULL) {
        printf("No records found.\n");
        return;
    }

    printf("Enter Roll Number to delete: ");
    scanf("%d", &rollNo);

    while (fscanf(fptr, "%d,%49[^,],%f\n", &s.roll, s.name, &s.marks) != EOF) {
        if (s.roll != rollNo) {
            fprintf(temp, "%d,%s,%.2f\n", s.roll, s.name, s.marks);
        } else {
            found = 1;
        }
    }

    fclose(fptr);
    fclose(temp);
    remove("students.txt");
    rename("temp.txt", "students.txt");

    if (found) {
        printf("Student record deleted.\n");
    } else {
        printf("Student not found.\n");
    }
}

int main() {
    int choice;
    while (1) {
        printf("\n===== Student Record Management =====\n");
        printf("1. Add Student\n");
        printf("2. Display Students\n");
        printf("3. Search Student\n");
        printf("4. Delete Student\n");
        printf("5. Exit\n");
        printf("Enter your choice: ");
        scanf("%d", &choice);

        switch (choice) {
            case 1: addStudent(); break;
            case 2: displayStudents(); break;
            case 3: searchStudent(); break;
            case 4: deleteStudent(); break;
            case 5: exit(0);
            default: printf("Invalid choice!\n");
        }
    }

    return 0;
}
