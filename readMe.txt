Explicação dos endpoints referentes ao macroprocesso:

	configuraçao do banco de dados:
		
		Passo 1 -> criar um banco de dados com o nome "backend_aic" (sem aspas)
		Passo 2 -> rodar a seguinte query no banco de dados criado:

			CREATE TABLE `macroprocesso` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`createdAt` datetime NOT NULL,
				`editedAt` varchar(255) DEFAULT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8

		Obs: se o nome do banco estiver correto e a query rodar com sucesso,
			os endpoints devem funcionar. Se não funcionarem, talvez seja necessario atualizar os
			dados do banco de dados no arquivo Db.class.php, dentro da pasta model

	endpoints:

	localhost/backendAic/view/macroprocesso.php

		Métodos aceitos:
			POST:
				Enviar um json no formato: {"name":"aqui vai um titulo"}
				
				Em caso de sucesso retorna: {"status":201,"success":true,"mensagens":["Macroprocesso criado"],"data":{"id":"UMNUMERO","name":"AQUIVAIOTITULO","createdAt":"0000-00-00 00:00:00","editedAt":null}}
				
				Possíveis status de erro: 400 (algum erro no formato da requisição), 405 (método não permitido), 500 (erro do servidor)
			
			GET:
				Em caso de sucesso retorna: {"status":200,"success":true,"mensagens":["Macroprocessos retornados"],"data": AQUI VAI UM ARRAY COM ARRAYS DE MARCROPROCESSOS}
				Possíveis status de erro: 500 (erro do servidor)

	localhost/backendAic/view/macroprocesso.php?id=AQUI VAI O ID DE UM MACROPROCESSO

		Métodos aceitos:
			GET:
				Em caso de sucesso retorna: {"status":200,"success":true,"mensagens":["Macroprocesso retornado"],"data":{"id":"UMNUMERO","name":"AQUIVAIOTITULO","createdAt":"0000-00-00 00:00:00","editedAt":null OU a data em que foi editado}}

				Possíveis status de erro: 400 (id invalido), 404 (macroprocesso não encontrado), 500 (erro do servidor)

			PUT:
				Enviar um json no formato: {"name":"aqui vai o novo titulo"}

				Em caso de sucesso retorna: {"status":200,"success":true,"mensagens":["Macroprocesso atualizado"],"data":{"id":"UMNUMERO","name":"AQUIVAIONOVOTITULO","createdAt":"0000-00-00 00:00:00","editedAt":"0000-00-00 00:00:00"}}

				Possíveis status de erro: 400 (id invalido, algum erro no formato ou algum erro nos dados informados), 404 (macroprocesso não encontrado), 500 (erro do servidor)
			

			DELETE:
				Em caso de sucesso retorna: {"status":200,"success":true,"mensagens":["Macroprocesso deletado"],"data":{"id":"UMNUMERO","name":"AQUIVAIOTITULO","createdAt":"0000-00-00 00:00:00","editedAt":null OU a data em que foi editado}}
				ou seja, no campo data retorna o macroprocesso que foi deletado

				Possíveis status de erro: 400 (id invalido), 404 (macroprocesso não encontrado), 500 (erro do servidor)
