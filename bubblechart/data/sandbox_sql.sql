SELECT MAX(datanumber_value) 
FROM data_numbers 
WHERE datanumber_datatype_id = 1 
AND datanumber_period_id=2;

SELECT * FROM data_numbers 
INNER JOIN loc_entities ON datanumber_ent_id=ent_id 
WHERE datanumber_datatype_id= 5 
AND datanumber_period_id=2