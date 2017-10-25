<?php
class helpers extends server_api {

        public $CONSULTANT;
        public $DEMANDE;

        public function __construct($bdd) {
                parent::__construct($bdd);
                $this->CONSULTANT = new Consultant($bdd);
                $this->DEMANDE = new Demande($bdd);
        }
	
	public function nbJoursAPoser($dateFromDu,$dateFromAu,$thelistMM,$thelistMS) {
		return $this->DEMANDE->nbJoursAPoser($dateFromDu,$dateFromAu,$thelistMM,$thelistMS);
	}
}
?>
