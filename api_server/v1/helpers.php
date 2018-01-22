<?php

include_once('model_singleton.php');

class helpers extends server_api {

        public $CONSULTANT;
        public $DEMANDE;

        public function __construct($bdd) {
                parent::__construct($bdd);
		$this->CONSULTANT =  get_consultant_singleton($bdd);
		$this->DEMANDE =  get_demande_singleton($bdd);
        }
	
	public function nbJoursAPoser($dateFromDu,$dateFromAu,$thelistMM,$thelistMS) {
		return $this->DEMANDE->nbJoursAPoser($dateFromDu,$dateFromAu,$thelistMM,$thelistMS);
	}
}
?>
