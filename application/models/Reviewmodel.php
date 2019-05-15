<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed - Conhecimentos');
  
    class Reviewmodel extends CI_Model {
        
        public function __construct() {
            parent::__construct();            
        }
        
        public function getNextReview($email) {
            if($email) {
                /*$sql = "SELECT rev_id, 
                               rev_categoria,
                               REPLACE(rev_produto, rev_categoria, '') as rev_produto,
	                       REPLACE(REPLACE(rev_opiniao, 'O que gostei:', '<br>O que gostei:'), 'O que não gostei:', '<br>O que não gostei:') as rev_opiniao,
                               RAND() as random
                        FROM   reviews a 
	                       LEFT JOIN total_avaliacoes b USING(rev_id) 
                        WHERE  rev_id NOT IN (SELECT rev_id
				              FROM   avaliacoes_usuario 
				              WHERE  ava_email = '". $email ."') AND
                               COALESCE(b.tot_quantidade, 0) < 5
                        ORDER BY b.tot_quantidade DESC, random
                        LIMIT 1";*/
                $sql = ""
                $query  = $this->db->query($sql);
                $review = $query->row_array();
                $avaliacao = array("rev_id"       => $review['rev_id'],
                                   "ava_email"    => $email,
                                   "ava_resposta" => "A");
                $this->db->insert('avaliacoes_usuario', $avaliacao);
                
                $sql = "UPDATE total_avaliacoes
                        SET    tot_quantidade = COALESCE(tot_quantidade, 0) + 1
                        WHERE  rev_id    = ". $review['rev_id'] .";";
                $this->db->query($sql);
                if ($this->db->affected_rows() === 0) {
                    $sql = "INSERT INTO total_avaliacoes (rev_id, tot_quantidade)
                            VALUES (".$review['rev_id'].", 1);";
                    $this->db->query($sql);
                }
                return $review;
            } else {
                return false;
            }
        }
        
        public function setRepostaReview($email, $review, $resposta){
            $avaliacao = array("ava_resposta" => $resposta);
            $this->db->update('avaliacoes_usuario', $avaliacao, array("rev_id"    => $review,
                                                                      "ava_email" => $email));                
        }
    }    
?>
