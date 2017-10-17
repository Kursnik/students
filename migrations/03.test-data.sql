insert into `users` (`name`)
       values ('student_1'), ('student_2'), ('student_3'), ('student_4'), ('student_5');
insert into `education` (`title`)
       values ('высшее'), ('среднее'), ('бакалавр'), ('магистр');
insert into `city` (`title`)
       values ('Москва'), ('Санк-Петерюург'), ('Тюмень'), ('Томск'), ('Новосибирск');

insert into `user_education` (`user_id`, `education_id`)
       values (1, 1), (2, 2), (3, 1), (4, 4), (5, 2);
insert into `user_city` (`user_id`, `city_id`)
       values (1, 2), (1, 4), (2, 4), (3, 5), (5, 4);