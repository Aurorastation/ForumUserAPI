# AuroraForum User API

A simple and relativey lightweight API used by various Aurora Bots to query the forum for User and Staff Data

## Usage

Generate a RSA Keypair and place it in the config folder (named public.pem and private.pem)

Use the console command `php artisan jwt:generatetoken [endpoint]` to generate a authentication token for a specified endpoint.

Set the `Authorization: Bearer [token]` header in your requests to the API

Create a UserData view in the Forum Database:
```
CREATE SQL SECURITY DEFINER VIEW view_userdata AS 
SELECT
	core_members.member_id AS forum_member_id,
	core_members.name AS forum_name,
	core_members.member_group_id AS forum_primary_group,
	core_members.mgroup_others AS forum_secondary_groups,
	core_login_links.token_identifier AS discord_id,
	core_pfields_content.field_15 AS ckey
FROM core_members
LEFT JOIN core_login_links ON core_members.member_id = core_login_links.token_member
LEFT JOIN core_pfields_content ON core_members.member_id = core_pfields_content.member_id
WHERE 
	(core_login_links.token_login_method = 3 OR core_login_links.token_login_method IS NULL)
```
