<?php

class Opportunity extends \HXPHP\System\Model
{

  static function table_name()
  {
    return 'opportunities';
  }

   //Relacionamnetos 1:1 entre as tabelas
   static $belongs_to = array(
      array('attribute', 'foreign_key' => 'attribute_id', 'class_name' => 'Attribute'),
      array('profile', 'foreign_key' => 'profile_id', 'class_name' => 'Profile'),
      array('benefit', 'foreign_key' => 'benefit_id', 'class_name' => 'Benefit')
   );

   public function relations()
   {
      return array(
         'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }

  public static function backVagaWeights(array $atributos){
    $pesos_oportunidade = array();
    for ($i=1; $i < 16 ; $i++) {
      $questao = 'question_' . $i; //concatena a expresão com o contador, para formar o campo
      $valor = $atributos['attribute_' . $i]; //recupera atributo selecionado para a vaga
      $quesito = Parameter::find_by_id($i); //Recupera o Atributo (Idioma, Experiencia...)
      $weigths = $quesito->weight_id; //ID do Atributo a ser recuperado o peso
      $pesosRecuperados = Weight::find_by_id($weigths);//Recupera os Pesos do Atributo
      $opcaoVaga = 'option_' . $valor; //Concatena a expressao com a Opcao Selecionada p/vaga
      $pesos_oportunidade[$i-1] = $pesosRecuperados->$opcaoVaga; //Array com os Pesos da Vaga
    }
    return $pesos_oportunidade;
  }
}