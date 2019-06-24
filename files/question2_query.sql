
SELECT u.first_name as "First Names", u.last_name as "Surname", u.id_number as "ID Number",
  
  GROUP_CONCAT(distinct(case when t.type='msisdn' then p.value else '' end) ORDER BY p.value ASC SEPARATOR '') as 'Cellphone',
  GROUP_CONCAT(distinct(case when t.type='record_number' then p.value else '' end) ORDER BY p.value ASC SEPARATOR '') as 'Record #',
  GROUP_CONCAT(distinct(case when t.type='network' then p.value else '' end) ORDER BY p.value ASC SEPARATOR '') as 'Network',
  GROUP_CONCAT(distinct(case when t.type='points' then p.value else '' end) ORDER BY p.value ASC SEPARATOR '') as 'Points',
  GROUP_CONCAT(distinct(case when t.type='card_number' then p.value else '' end) ORDER BY p.value ASC SEPARATOR '') as 'Card Number',
  GROUP_CONCAT(distinct(case when t.type='gender' then p.value else '' end) ORDER BY p.value ASC SEPARATOR '') as 'Gender'

  FROM tUSER u 
  LEFT JOIN tprofile p ON u.id = p.tUSER_id
  LEFT JOIN ttypes t ON p.tTYPES_id = t.id

  WHERE u.id_number = '1114567890123' and Cellphone 
  GROUP BY p.tUSER_id;
  -- AND (t.type='msisdn' AND p.value='0720112966');