all:
	@rm -f ../uploads/*
	@cp img/* ../uploads/.

	@rm -f all.sql
	@cp mysql.sql all.sql
	@cat insert.sql >> all.sql
	mysql -u root -p < all.sql
