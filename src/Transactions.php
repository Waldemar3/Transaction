<?php

require_once 'Table.php';

class Transactions extends Table
{
	public function read($id){
		if (!ctype_digit(strval($id))) throw new Exception('Переданное значение не является числом');

		$query = "
			select 
				main.amount+(select amount from ". $this->table ." where id = main.paid_by)-(select amount from ". $this->table ." where id = main.paid_to) 
				as total_money from ". $this->table ." main where id = :id
		";

		$stmnt = $this->pdo->prepare($query);
        $stmnt->execute(['id' => $id]);

		return json_encode($stmnt->fetchAll(\PDO::FETCH_ASSOC));
	}

	public function factory(){
		$query = "
			INSERT INTO ". $this->table ." (id,paid_by,paid_to,amount,trdate)
			VALUES
			(01, 01, 10, 6.00, '2021-01-01'),
			(02, 01, 11, 3.00, '2021-01-02'),
			(03, 01, 12, 4.00, '2021-01-03'),
			(04, 10, 02, 2.00, '2021-01-04'),
			(05, 10, 02, 1.00, '2021-01-04'),
			(06, 11, 02, 6.00, '2021-01-06'),
			(07, 11, 02, 7.00, '2021-01-06'),
			(08, 12, 02, 2.00, '2021-01-07'),
			(09, 12, 02, 3.00, '2021-01-08'),
			(10, 10, 02, 1.00, '2021-01-09'),
			(11, 01, 10, 3.00, '2021-01-10'),
			(12, 10, 02, 5.00, '2021-01-10');
		";

		$stmnt = $this->pdo->prepare($query);
		$stmnt->execute();
	}

    protected function migrate(): string {
	    return "
			id int(11) unsigned NOT NULL,
			paid_to int(11) unsigned NOT NULL,
			paid_by int(11) unsigned NOT NULL,
			amount int NOT NULL,
			trdate datetime NOT NULL,
			PRIMARY KEY (id), 
			KEY paid_to (paid_to),
			KEY paid_by (paid_by)
		";
	}
}