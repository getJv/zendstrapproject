select 
	mr.member_id as "user_id",
r.id as "role_id",
r.name as "role_name",
p.system_id as "system_id",
p.name as "permission_id",
p.action_name as "action"
from permissions as p
inner join role_permissions as rp on (p.id = rp.permission_id)
inner join roles as r on (r.id = rp.role_id)
inner join member_roles as mr on (r.id = mr.role_id)

where mr.member_id = 1
and r.id = 2