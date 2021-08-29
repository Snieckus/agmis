<b>TASK:<b>

![image](https://user-images.githubusercontent.com/38216432/131244798-e2fc80a4-bc28-4b7b-8963-dde07325bd61.png)

<b>ROLES:</b><br>
Each role represents number which is used app wide:
    <ul><li>RECEPTIONIST = 0;</li>
        <li>PATIENT = 1;</li>
        <li>DOCTOR = 2;</li></ul>
    
<b>STEPS TO MAKE PROGRAM RUNNABLE:</b>
    
1. Launch project.
2. Configure .env file with database connection and mailing parameters.
3. Run migrations with extra flag --seed (full command: php artisan migrate:refresh --seed) to crate all tables with users and drugs seeded.

<b>All users password is 123456789</b>

<b>API USAGE:</b><br>
    It is mandatory to use API password for full api ussage. Api password is shown in .env file as API_PASSWORD. Once password is correct, api usage is available untill sesion is destroyed. 

