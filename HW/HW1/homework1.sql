/*
參考下列表格，以 SQL 回答下列的查詢
EMP (emp#, name, dept#, job, manager#, salary, age)
DEP (dept#, dname, location)
CANDIDATE (emp#, name, dept#, salary)
*/

# 1. 如果職員的薪水高於 15000，則列出職員的姓名和他(她) 所屬的部門位置。
SELECT NAME, LOCATION
FROM EMP, DEP
WHERE EMP.DEPT = DEP.DEPT AND SALARY > 15000;

# 2. 將部門 40 的員工根據員工編號，依序個別列出各員工的編號、姓名和薪水。
SELECT EMP, NAME, SLALAY
FROM EMP
WHERE DEP = 40
ORDER BY EMP;

# 3. 找出年紀大於 30 的 clerks 的平均薪水為多少。
SELECT AVG(SALARY)
FROM EMP
WHERE JOB = 'CLERK' AND AGE > 30;

# 4. 多少不同的工作是由部門 40 的員工來執行的?
SELECT COUNT (DISTINCE JOB)
FROM EMP
WHERE DEP = 40;

# 5. 列出所有的工作和每個工作的平均薪水。
SELECT JOB, AVG (SALARY)
FROM EMP
GROUP BY JOB;

# 6. 列出所有的員工姓名和他們所屬的部門位置。
SELECT EMP.NAME, DEP.LOCATION
FROM EMP, DEP
WHERE EMP.DEPT = DPT.DEPT;

# 7. 如果有員工的薪水超過他(她)的主管，則列出他(她)的 姓名和他(她)主管的姓名。
SELECT FIRST.NAME, SECOND.NAME
FROM EMP FIRST, EMP SECOND
WHERE FIRST.MANAGER = SECOND.NAME AND FIRST.SALARY > SECOND.SALARY;

# 8. 找出所有在 Columbus 且薪水平均小於 20000 的部門，按照部門的平均薪水遞減排列，依序列出這些部門的部門編號和平均薪水。
SELECT EMP.DEPT, AVG(SALARY)
FROM EMP, DEP
WHERE EMP.DEPT = DEP.DEPT AND DEP.LOCATION = "Columbus"
GROUP BY DEPT
HAVING AVG(SALARY) < 20000
ORDER BY AVG(SALARY) DESC;

# 9. 將沒有員工的部門從 DEP 表格中剔除。
DELETE
FROM DEP
WHERE NOT EXISTS (SELECT *
				  FROM EMP
                  WHERE EMP.DEPT = DPT.DEPT);

# 10. 調整 EMP 表格中的員工薪水(如果此人有出現 Candidate表格中 )，調漲百分之十。
UPDATE EMP
SET SALARY = SALARY * 1.1
WHERE EXISTS(SELECT *
			 FROM CANDIDATE
             WHERE EMP.EMP = CANDIDATE.EMP);


