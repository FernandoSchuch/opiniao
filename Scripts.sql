ALTER TABLE reviews ADD COLUMN rev_id NUMERIC(10);
ALTER TABLE reviews ADD CONSTRAINT pk_rev PRIMARY KEY (rev_id);

UPDATE reviews a
SET    rev_id = b.id
FROM   (SELECT ROW_NUMBER() OVER() as id, REV_ARQUIVO
        FROM   reviews) b
WHERE   a.rev_arquivo = b.rev_arquivo;

CREATE TABLE avaliacoes_usuario (
    rev_id NUMERIC(10),
    ava_email VARCHAR(100),
    ava_resposta VARCHAR(1) --P=Possui, N=Não possui, D=Dúvida, A=Aguardando
);
ALTER TABLE avaliacoes_usuario ADD CONSTRAINT pk_ava PRIMARY KEY (rev_id);
ALTER TABLE avaliacoes_usuario ADD CONSTRAINT fk_ava_rev FOREIGN KEY (rev_id) REFERENCES reviews(rev_id);

CREATE TABLE total_avaliacoes (
    rev_id NUMERIC(10),
    tot_quantidade NUMERIC(5)
);

ALTER TABLE total_avaliacoes ADD CONSTRAINT pk_tot PRIMARY KEY (rev_id);
ALTER TABLE total_avaliacoes ADD CONSTRAINT fk_tot_rev FOREIGN KEY (rev_id) REFERENCES reviews(rev_id);

ALTER TABLE avaliacoes_usuario ADD COLUMN ava_data TIMESTAMP;

--Select para inserir as reviews no mysql
SELECT 'INSERT INTO reviews (rev_id, rev_categoria, rev_data, rev_produto, rev_estrelas, rev_usuario, rev_opiniao) VALUES ('||
       rev_id||','''||
	   rev_categoria||''','''||
	   to_char(rev_data, 'yyyymmdd')||''','''||
	   rev_produto||''','||
	   rev_estrelas||','''||
	   rev_usuario||''','''||
	   rev_opiniao||''''||');'
FROM (
	SELECT *, COUNT(*) OVER(PARTITION BY rev_produto) AS contador
	FROM (
		SELECT * 
		FROM (
			SELECT *
			FROM   reviews
			WHERE  rev_produto NOT IN (SELECT rev_produto
										FROM   reviews a
										WHERE  rev_produto IN (SELECT rev_produto
															   FROM   reviews
															   GROUP BY rev_produto
															   HAVING COUNT(*) = 5) AND
											   EXISTS (SELECT 1
													   FROM   reviews x
													   WHERE  x.rev_id <> a.rev_id AND
															  x.rev_produto = a.rev_produto AND
															  x.rev_opiniao = a.rev_opiniao)) AND
			rev_produto IN (SELECT rev_produto
						   FROM   reviews
						   GROUP BY rev_produto
						   HAVING COUNT(*) = 5)) A
		WHERE rev_id NOT IN (68764, 55983, 39496, 11671, 34228, 55529, 43235, 9858, 4533) AND
			  LENGTH(rev_opiniao) > 1
	) A 
) A
WHERE a.contador = 5;

DELETE FROM avaliacoes_usuario WHERE ava_email = 'teste';
UPDATE total_avaliacoes a
SET    tot_quantidade = (SELECT COUNT(*)
                         FROM   avaliacoes_usuario b
                         WHERE  b.rev_id = a.rev_id);

DELETE FROM avaliacoes_usuario
WHERE ava_email = 'teste';

UPDATE total_avaliacoes a
SET    tot_quantidade = (SELECT COUNT(*)
                         FROM   avaliacoes_usuario b
                         WHERE  a.rev_id = b.rev_id)