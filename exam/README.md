# BetterDiet
## Datubazes Db.php darbība un funkciju izpilde
## Create funkicija
### Funkcijā padod tabulu, un tad datu array
 $data = [
    "username"=> "Janis",
     "password"=>"janis123",
   ];
#### $this->db->create("users", $data);
## Update funkicija
### Funkcijā padod tabulu, datu array, un id
$data = [
    "username"=> "Janis",
     "password"=>"janis123",
  ];
#### $this->db->update("users", $data, $id);
## Find funkcija
### Funkciju izmanto, lai savāktu specificētus datus no datubāzes, piem."WHERE name = janis" padod tabulu, un tad datu array
#### $this->db->find("meals", ["user_id"=>1, "food"=>"banana"]);
####  - tiek paņemti dati no tabulas "meals", kur user_id = 1 un food = banana
## Delete funkcija
### Funkciju izmanto, lai izdzestu datus, padod tabulu un tad id
#### $this->db->delete("meals", 1);
####  - tiek izdzesti dati no tabulas "meals", kur id = 1
## DeleteWhere funkcija
### Funkciju izmanto, lai izdzestu datus, padodot konkretus parametrus, tabulu, colonnu un vertibu
#### $this->db->deleteWhere("users", "username","janis);
####  - tiek izdzesti dati no tabulas "meals", kur username = janis

