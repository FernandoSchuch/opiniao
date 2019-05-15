<?php
if(! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed - busca' );
error_reporting(0);
class Busca extends CI_Controller {	
        
	public function __construct() {
            parent::__construct();
            $this->load->model('reviewmodel');
	}
	
        public function getInstrucoes(){
            echo '<div>
                    <h3>Instruções</h3>
                    <p>
                        Ao clicar em "Começar", serão apresentadas opiniões sobre produtos postadas em um site de vendas brasileiro.<br>
                        Para cada cenário, você poderá escolher uma entre quatro opções que melhor classifica a situação: <br><br>
                        
                        '. $this->getExplicao() .'
                        <br><br>
                        Você pode terminar a pesquisa a qualquer momento, clicando no botão "Finalizar".
                        <form action="'. base_url() .'index.php/Busca/getReview" id="formComecar" method="post" >
                            <button type="submit" class="btn btn-success">Começar</button>    
                        </form>
                    </p>
                  </div>';
	}
        
	public function getReview(){            
            $parametros = $this->input->post();
            $dados      = $this->reviewmodel->getNextReview($parametros['email']);
            echo '<div class="card" style="margin-top: 20px">
                    <div class="card-header" >
                        <b>Categoria:</b> '. $dados['rev_categoria'] .' <br> 
                        <b>Produto:</b> '. $dados['rev_produto'] .'
                        <input type="hidden" id="revId" value="'. $dados['rev_id'] .'"/>
                    </div>
                    <div class="card-body">
                        <p class="div-opiniao rounded">"'. $dados['rev_opiniao'] .'"</p>
                        <form action="'. base_url() .'index.php/Busca/setResposta" id="formResposta" method="post">
                            <div class="container">
                                <div class="row div-radio">
                                    <div>
                                        <input id="radio1" type="radio" name="resposta" value="P" />
                                    </div>
                                    <div class="div-label">
                                        <label for="radio1">Possui ou conhece alguém que possui o produto</label>
                                    </div>                                    
                                </div>
                                <div class="row div-radio">
                                    <div>
                                        <input id="radio2" type="radio" name="resposta" value="N" />
                                    </div>
                                    <div class="div-label">
                                        <label for="radio2"> Não possui o produto, mas deseja comprá-lo</label><br>
                                    </div>
                                </div>
                                <div class="row div-radio">
                                    <div>
                                        <input id="radio3" type="radio" name="resposta" value="F" />
                                    </div>
                                    <div class="div-label">
                                        <label for="radio3"> Não possui o produto</label><br>
                                    </div>
                                </div>
                                <div class="row div-radio">
                                    <div>
                                        <input id="radio4" type="radio" name="resposta" value="D" />
                                    </div>
                                    <div class="div-label">
                                        <label for="radio4"> Não há como afirmar </label>
                                    </div><br>
                                </div>
                                <div class="row div-radio">
                                    <div>
                                        <input id="radio5" type="radio" name="resposta" value="R" />
                                    </div>
                                    <div class="div-label">
                                        <label for="radio5"> Não está relacionado ao produto</label>
                                    </div>
                                </div>
                            </div><br>
                            <button type="button" class="btn btn-link" style="padding-left: 0px" data-toggle="modal" data-target="#modalInstrucoes">Ver Instruções</button><br>
                            <button class="btn" id="btFinalizar" livesite="'. base_url() .'index.php/Busca/finalizar" style="float: right">Finalizar</button>
                            <button type="submit" class="btn btn-success">Próxima</button>
                        </form>
                    </div>
                    <div class="modal" id="modalInstrucoes">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">'.
                                    $this->getExplicao()
                                .'</div>
                                <div class="modal-footer rodape-modal">
                                    <span>'. $dados['coh_titulo'] .'</span>                                    
                                    <button  type="button" class="btn btn-success" style="float: right" data-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>';
	}
        
        public function setResposta(){            
            $parametros = $this->input->post();
            
            $this->reviewmodel->setRepostaReview($parametros['email'], $parametros['review'], $parametros['resposta']);
            echo base_url() . 'index.php/Busca/getReview';
	}
        
        public function finalizar(){            
            echo '<div>
                    <h3>Obrigado!</h3>
                    <p>
                        Agradeço pela tua participação.<br><br>
                        Se possível, compartilhe o link desta página com amigos. Quanto mais pessoas ajudarem, menos opiniões tendenciosas teremos nos sites de venda.
                    </p>
                  </div>';
	}
        
        public function getExplicao(){
            return '<ul>
                        <li><b>Possui ou conhece alguém que possui o produto:</b> é possível perceber que o usuário que postou a review realmente possui o produto, ou pelo menos conhece alguém que o tenha;</li>
                        <li><b>Não possui o produto, mas deseja comprá-lo:</b> o usuário não possui o produto, mas expressa o desejo de adquiri-lo em breve;</li>
                        <li><b>Não possui o produto:</b> o usuário não possui o produto e não demonstra interesse em comprá-lo;</li>
                        <li><b>Não há como afirmar:</b> a opinião está relacionada ao produto, mas não há como afirmar se o usuário o possui ou não;</li>
                        <li><b>Não está relacionado ao produto:</b> a opinião não está relacionada ao produto que está sendo avaliado.</li>
                    </ul>';
        }
}	
?>