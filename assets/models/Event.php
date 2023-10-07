<?php
class Event {
    public $id;
    public $nome_evento;
    public $attendees;
    public $data_evento;
    public $id_creator;
    public $description;

    public function __construct($id, $nome_evento, $attendees, $data_evento, $id_creator, $description) {
        $this->id = $id;
        $this->nome_evento = $nome_evento;
        $this->attendees = $attendees;
        $this->data_evento = $data_evento;
        $this->id_creator = $id_creator;
        $this->description= $description;

    }
}