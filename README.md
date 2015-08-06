search a snippet with "apples" OR "oranges" characters
E is automatic escaping for "|", just remove to search for a "|"

grep -Erin 'apples|oranges' 

AND operator :
grep -Erin 'apples.*oranges' 
