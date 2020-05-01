USE HuntAndGather; 
        
select a.name, a.id from allergen a
join allergenmeal am on am.allergen_id = a.id
where am.meal_id = 1