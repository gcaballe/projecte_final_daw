INSTRUCCIONS D'US:

executar:  crear_DDL.sql

	ALERTA: aquest script conte 3 inserts: els rols. ja que si s'optés per no instalar les dades demo, fan falta.
	
executar:  insert_demo_data.sql

executar:  crear_DDL.sql


si es vol eliminar la demo data:

	delete_demo_data.sql
	
	si es vol tornar a instalar la demo data:
	
	insert_demo_data.sql
	
	

si es vol fer tot de cop: eliminar tota la database i tornar-la a crear amb les instruccions DDL: 
	
	delete_full.sql