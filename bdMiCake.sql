CREATE TABLE articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    body TEXT,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
);

/* Luego insertamos algunos artículos para probar */
INSERT INTO articles (title,body,created)
    VALUES ('El título', 'Esto es el cuerpo del artículo.', NOW());
INSERT INTO articles (title,body,created)
    VALUES ('Un título de nuevo', 'Y el cuerpo sigue.', NOW());
INSERT INTO articles (title,body,created)
    VALUES ('El título ataca de nuevo', '¡Esto es realmente emocionante! No.', NOW());articlesarticlesarticles