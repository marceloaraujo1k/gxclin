<?php
header('Content-Type: application/xml; charset=utf-8');
#Definindo as variáveis

#Dados Operadora:
$_XML['versao_tiss']='030303';
$_XML['registro_ans'] = '1111';

#Dados Prestador:
$_XML['codigo_credenciamento'] = '12345';
$_XML['cnpj'] = '0000000000000';
$_XML['prestador'] = 'Hospital ABCD';

#Dados do atendimento e beneficiário
$_XML['data_hora'] = '03/04/2018 22:15:00';
$_XML['rn'] = 'N'; #Não 
$_XML['tipo_atd'] = 'Ambulatorial'; 
$_XML['carater'] = 'E'; #Eletivo 
$_XML['guia'] = '1111'; 
$_XML['senha'] = '2222'; 
$_XML['medico'] = 'Dr. Fabiano'; 
$_XML['crm'] = '0000'; 
$_XML['cbos'] = '';
#Dados do beneficiário
$_XML['nome'] = 'Fulano de Tal';
$_XML['dt_nascimento'] = '01/01/1980';
$_XML['carteira']  = '4444444444444444';
$_XML['validade'] = '31/12/2030';

#Dados da Fatura / Lote
$_XML['fatura_remessa'] = '123';

#Dados do procedimento realizado
$_XML['tabela'] = '22';
$_XML['procedimento_tuss'] = '10101012';
$_XML['descricao_proced'] = 'Consulta em consultório';
$_XML['valor_unitario'] = '500,00';
$_XML['qtde'] = '1';
$_XML['valor_total'] = '500,00';

$_XML['tipoTransacao'] = 'ENVIO_LOTE_GUIAS';
$_XML['sequencialTransacao'] = '6658';
$_XML['dataRegistroTransacao'] = '2018-01-18';
$_XML['horaRegistroTransacao'] = '10:00:00';

 # Utilize a variável $_XML['hash_dados'] para concatenar os dados e calcular o HASH antes do terceiro bloco
$_XML['hash_dados'] = '';

#A variável $_XML['hash'] está nula pois deve ser calculada com os dados dos elementos(tags) do XML
$_XML['hash'] = 'calculo do HASH';

//$_XML[''] = ''; // para criar novas variáveis apenas siga o padrão

#versao XML e codificação
$xml = new DOMDocument("1.0", "ISO-8859-1"); 
//também poderia ser UTF-8
 
#remove os espacos em branco
$xml->preserveWhiteSpace = false;

#Realizar a quebra dos blocos do XML por linha
$xml->formatOutput = true;

$root = $xml->createElement('xml');
$xml->appendChild($root);

		//Criação dos elementos do Namespace ans:mensagemTISS
		 $xml->createAttributeNS('http://www.w3.org/2000/09/xmldsig#', 'ds:attr');
		$xml->createAttributeNS( 'http://www.w3.org/2001/XMLSchema-instance', 'xsi:attr' );
		//$xml->createAttributeNS( 'http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV3_03_01.xsd', 'schemaLocation:attr' );
		$xml->createAttributeNS( 'http://www.ans.gov.br/padroes/tiss/schemas', 'ans:attr' );
        
// Nó / Bloco Principal
// ans:mensagemTISS
$mensagemTISS = $xml->createElement("ans:mensagemTISS");
$root->appendChild($mensagemTISS);

	/* primeiro bloco */
	// ans:mensagemTISS / ans:cabecalho
	$cabecalho = $xml->createElement("ans:cabecalho");
	$mensagemTISS->appendChild($cabecalho);
	
		// ans:mensagemTISS / ans:cabecalho / ans:identificacaoTransacao
		$identificacaoTransacao = $xml->createElement("ans:identificacaoTransacao");
		$cabecalho->appendChild($identificacaoTransacao);
		
				# ans:tipoTransacao
				$tipoTransacao = $xml->createElement("ans:tipoTransacao", $_XML['tipoTransacao']);
				$identificacaoTransacao->appendChild($tipoTransacao);
				
				#sequencialTransacao
				$sequencialTransacao = $xml->createElement("ans:sequencialTransacao", $_XML['sequencialTransacao']);
				$identificacaoTransacao->appendChild($sequencialTransacao);

				#dataRegistroTransacao
				$dataRegistroTransacao = $xml->createElement("ans:dataRegistroTransacao", $_XML['dataRegistroTransacao']);
				$identificacaoTransacao->appendChild($dataRegistroTransacao);

				#horaRegistroTransacao
				$horaRegistroTransacao = $xml->createElement("ans:horaRegistroTransacao", $_XML['horaRegistroTransacao']);
				$identificacaoTransacao->appendChild($horaRegistroTransacao);
			
		
		// ans:mensagemTISS / ans:cabecalho / ans:origem
		$origem = $xml->createElement("ans:origem");
		$cabecalho->appendChild($origem);
		
				// ans:mensagemTISS / ans:cabecalho / ans:origem / identificacaoPrestador
				$identificacaoPrestador = $xml->createElement("ans:identificacaoPrestador", $_XML['cnpj']);
				$origem->appendChild($identificacaoPrestador);
				
		
		// ans:mensagemTISS / ans:cabecalho / ans:destino
		$destino = $xml->createElement("ans:destino");
		$cabecalho->appendChild($destino);
		
				// ans:mensagemTISS / ans:cabecalho / ans:registroANS
				$registroANS = $xml->createElement("ans:registroANS", $_XML['registro_ans']);
				$destino->appendChild($registroANS);
		
		// ans:mensagemTISS / ans:cabecalho / ans:Padrao
		$Padrao = $xml->createElement("ans:Padrao", $_XML['versao_tiss']);
		$cabecalho->appendChild($Padrao);
	
	
	/* segundo bloco */
	// ans:mensagemTISS / ans:prestadorParaOperadora
	$prestadorParaOperadora = $xml->createElement("ans:prestadorParaOperadora");
	$mensagemTISS->appendChild($prestadorParaOperadora);
	
		// ans:mensagemTISS / ans:prestadorParaOperadora / loteGuias
		$loteGuias = $xml->createElement("ans:loteGuias");
		$prestadorParaOperadora->appendChild($loteGuias);		

			// ans:mensagemTISS / ans:prestadorParaOperadora / loteGuias / numeroLote
			$numeroLote = $xml->createElement("ans:numeroLote", $_XML['fatura_remessa']);
			$loteGuias->appendChild($numeroLote);	
 
 			// ans:mensagemTISS / ans:prestadorParaOperadora / loteGuias / guiasTISS
			$guiasTISS = $xml->createElement("ans:guiasTISS");
			$loteGuias->appendChild($guiasTISS);	

// Calculo o Hash - Você poderia gerar os dados, usar um (replace do PHP) para substituir as tags, e pegar apenas os dados
$_XML['hash_dados'] = '' ;
$_XML['hash'] = md5($_XML['hash_dados']);	

	/* terceiro bloco */
	// ans:mensagemTISS / ans:epilogo
	$epilogo = $xml->createElement("ans:epilogo");
	$mensagemTISS->appendChild($epilogo);
	
		// ans:mensagemTISS / ans:epilogo / ans:hash
		$hash = $xml->createElement("ans:hash", $_XML['hash']);
		$epilogo->appendChild($hash);	

# Comando para salvar/gerar o arquivo XML TISS
# Geralmente o nome do arquivo é o HASH que foi calculado ou número do lote, pois são informações únicas.
# você pode usar as variáveis: $_XML['fatura_remessa'] . $_XML['hash']


$xml->save("xml_tiss.xml");


# Imprime / Gera o xml em tela
echo $xml->saveXML();
?>
