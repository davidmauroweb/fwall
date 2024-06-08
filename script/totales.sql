SELECT COUNT(block) AS '' FROM fwall.fwalls WHERE userId LIKE 'loberazcasacentral' AND block LIKE 'bp' AND time > DATE_SUB(NOW(),INTERVAL 24 HOUR) GROUP BY block;
