CREATE SCHEMA lbaw2362; 
SET search_path TO lbaw2362;

-- Drop Tables

DROP TABLE IF EXISTS voteNotification;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS commentNotification;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS voteComment;
DROP TABLE IF EXISTS voteQuestions;
DROP TABLE IF EXISTS commentOnComment;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS questionTag;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS role;
DROP TABLE IF EXISTS photo;


-- Create Tables

CREATE TABLE photo(
    id SERIAL PRIMARY KEY,
    path TEXT DEFAULT NULL
);

CREATE TABLE role(
    id INT PRIMARY KEY,
    roleName TEXT NOT NULL
);

CREATE TABLE users(
   id SERIAL PRIMARY KEY,
   name TEXT NOT NULL,
   email TEXT NOT NULL CONSTRAINT users_email_uk UNIQUE,
   password TEXT NOT NULL,
   rating INT DEFAULT 0,
   accountCreated TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
   role INT NOT NULL REFERENCES role(id) ON UPDATE CASCADE,
   photoId INTEGER REFERENCES photo (id) ON DELETE SET NULL ON UPDATE CASCADE,
   isDeleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    tagName TEXT NOT NULL CONSTRAINT tag_name_uk UNIQUE
);

CREATE TABLE question(
    id SERIAL PRIMARY KEY,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    voteCount INT DEFAULT 0,
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    usersId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    isDeleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE questionTag(
    questionId INTEGER NOT NULL REFERENCES question (id),
    tagId INTEGER NOT NULL REFERENCES tag (id),
    PRIMARY KEY (questionId, tagId)
);

CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    content TEXT NOT NULL,
    voteCount INT DEFAULT 0,
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    usersId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    questionId INTEGER NOT NULL REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE,
    isDeleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE commentOnComment(
    mainCommentId INTEGER NOT NULL REFERENCES comment(id) ON DELETE CASCADE ON UPDATE CASCADE,
    subCommentId INTEGER NOT NULL REFERENCES comment (id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (mainCommentId, subCommentId)
);

CREATE TABLE voteQuestions(
    updown BOOLEAN NOT NULL,
    usersId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    questionId INTEGER NOT NULL REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (usersId, questionId)
);

CREATE TABLE voteComment(
    updown BOOLEAN NOT NULL,
    usersId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    commentId INTEGER NOT NULL REFERENCES comment (id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (usersId, commentId)
);

CREATE TABLE notification(
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    status BOOLEAN DEFAULT FALSE NOT NULL,
    usersId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    questionId INTEGER REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE commentNotification(
    id SERIAL PRIMARY KEY,
    notificationId INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE ON UPDATE CASCADE,
    commentId INTEGER NOT NULL REFERENCES comment (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE report(
    id SERIAL PRIMARY KEY,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    reason TEXT NOT NULL,
    usersReporterId INTEGER REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    commentId INTEGER REFERENCES comment (id) ON DELETE CASCADE ON UPDATE CASCADE,
    questionId INTEGER REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE voteNotification(
    id SERIAL PRIMARY KEY,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    status BOOLEAN DEFAULT FALSE NOT NULL,
    updown BOOLEAN NOT NULL,
    usersId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    commentId INTEGER REFERENCES comment (id) ON DELETE CASCADE ON UPDATE CASCADE,
    questionId INTEGER REFERENCES question (id) ON DELETE CASCADE ON UPDATE CASCADE,
    voterId INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
);

--POPULATE--

--photos
INSERT INTO photo (path) VALUES
('photos/photo1.jpg'),
('photos/photo2.jpg'),
('photos/photo3.jpg'),
('photos/photo4.jpg'),
('photos/photo5.jpg'),
('photos/photo6.jpg'),
('photos/photo7.jpg'),
('photos/photo8.jpg'),
('photos/photo9.jpg'),
('photos/photo10.jpg'),
('photos/photo11.jpg'),
('photos/photo12.jpg'),
('photos/photo13.jpg'),
('photos/photo14.jpg'),
('photos/photo15.jpg'),
('photos/photo16.jpg'),
('photos/photo17.jpg'),
('photos/photo18.jpg'),
('photos/photo19.jpg'),
('photos/photo20.jpg');


--Populate role
INSERT INTO role(id, roleName) VALUES
(0, 'normal users'),
(1, 'moderator'),
(2, 'admin');


-- Populate userss
INSERT INTO users (name, email, password, role, photoId) VALUES 
('users 1', 'users1@example.com', 'password1', 0, 1),  -- normal users
('users 2', 'users2@example.com', 'password2', 0, 2),  -- normal users
('users 3', 'users3@example.com', 'password3', 0, 3),  -- normal users
('users 4', 'users4@example.com', 'password4', 0, 4),  -- normal users
('users 5', 'users5@example.com', 'password5', 0, 5),  -- normal users
('users 6', 'users6@example.com', 'password6', 0, 6),  -- normal users
('users 7', 'users7@example.com', 'password7', 0, 7),  -- normal users
('users 8', 'users8@example.com', 'password8', 0, 8),  -- normal users
('users 9', 'users9@example.com', 'password9', 0, 9),  -- normal users
('users 10', 'users10@example.com', 'password10', 0, 10),  -- normal users
('Admin 1', 'admin1@example.com', 'password11', 2, 11),  -- admin users
('Admin 2', 'admin2@example.com', 'password12', 2, 12),  -- admin users
('Admin 3', 'admin3@example.com', 'password13', 2, 13),  -- admin users
('Admin 4', 'admin4@example.com', 'password14', 2, 14),  -- admin users
('Admin 5', 'admin5@example.com', 'password15', 2, 15),  -- admin users
('Moderator 1', 'mod1@example.com', 'password16', 1, 16),  -- moderator
('Moderator 2', 'mod2@example.com', 'password17', 1, 17),  -- moderator
('Moderator 3', 'mod3@example.com', 'password18', 1, 18),  -- moderator
('Moderator 4', 'mod4@example.com', 'password19', 1, 19),  -- moderator
('Moderator 5', 'mod5@example.com', 'password20', 1, 20);  -- moderator



-- Populate tags
INSERT INTO tag(tagName) VALUES
('Database'),
('SQL'),
('Web Development'),
('Programming'),
('Python'),
('JavaScript');


-- Populate questionTag
INSERT INTO questionTag (questionId, tagId) VALUES
(1, 1),  -- Question 1 is associated with Tag 1
(1, 2),  -- Question 1 is associated with Tag 2
(2, 2),  -- Question 2 is associated with Tag 2
(2, 3);  -- Question 2 is associated with Tag 3


-- Populate questions
INSERT INTO question(date, title, content, usersId) VALUES
('2023-10-23 09:00:00', 'How to normalize a database?', 'I need help with database normalization. Any tips?', 1),
('2023-10-23 10:00:00', 'Best practices for SQL?', 'What are the best practices for writing SQL queries?', 2);


-- Populate comments
INSERT INTO comment(date, content, usersId, questionId) VALUES
('2023-10-23 10:30:00', 'You can start with the 1NF, 2NF, and 3NF.', 3, 1),
('2023-10-23 11:00:00', 'Avoid SELECT *. Always specify your columns.', 4, 2);

-- Populate voteQuestions
INSERT INTO voteQuestions(updown, usersId, questionId) VALUES
(TRUE, 3, 1),  -- users3 upvoted Question1
(FALSE, 4, 2); -- users4 downvoted Question2


-- Populate voteComment
INSERT INTO voteComment(updown, usersId, commentId) VALUES
(TRUE, 1, 1),  -- users1 upvoted Comment1
(FALSE, 2, 2); -- users2 downvoted Comment2


-- Populate notifications
INSERT INTO notification(content, usersId) VALUES
('Your question received an upvote.', 1),
('Your comment was downvoted.', 2);

-- Populate commentNotification
INSERT INTO commentNotification(notificationId, commentId) VALUES
(1, 1),
(2, 2);


-- Populate reports
INSERT INTO report(reason, usersReporterId, commentId) VALUES
('Spam comment', 5, 1),
('Offensive content', 6, 2);

-- Populate commentOnComment
INSERT INTO commentOnComment(mainCommentId, subCommentId) VALUES
(1, 2);


INSERT INTO voteNotification(date, updown, usersId, voterId, questionId) VALUES
('2023-10-23 10:30:00', TRUE, 1, 3, 1),
('2023-10-23 10:35:00', FALSE, 2, 4, 2),
('2023-10-23 10:40:00', TRUE, 1, 5, 1),
('2023-10-23 10:45:00', FALSE, 2, 6, 2);


-- INDEXES --

CREATE INDEX idx_users_email ON users USING btree(email);
CLUSTER users USING idx_users_email;

CREATE INDEX idx_users_rating ON users USING btree(rating);

CREATE INDEX idx_question_date ON question USING btree(date);
CLUSTER question USING idx_question_date;

CREATE INDEX idx_question_title ON question USING btree(title);

CREATE INDEX idx_comment_date ON comment USING btree(date);
CLUSTER comment USING idx_comment_date;

CREATE INDEX idx_comment_questionId ON comment USING btree(questionId);

CREATE INDEX idx_notification_date ON notification USING btree(date);
CLUSTER notification USING idx_notification_date;

CREATE INDEX idx_notification_users ON notification USING btree(usersId);


--FTS--

--question--

ALTER TABLE question ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION question_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('simple', NEW.title), 'A') ||
            setweight(to_tsvector('simple', NEW.content), 'B')
        );
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER question_search_update
 BEFORE INSERT OR UPDATE ON question
 FOR EACH ROW
 EXECUTE PROCEDURE question_search_update();

CREATE INDEX idx_search_question ON question USING GIN (tsvectors);

--users--

ALTER TABLE users ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION users_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('simple', NEW.name), 'A') ||
            setweight(to_tsvector('simple', NEW.email), 'B')
        );
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER users_search_update
 BEFORE INSERT OR UPDATE ON users
 FOR EACH ROW
 EXECUTE PROCEDURE users_search_update();

CREATE INDEX idx_search_users ON users USING GIN (tsvectors);


--comment--

ALTER TABLE comment ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION comment_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
        NEW.tsvectors = setweight(to_tsvector('simple', NEW.content), 'A');
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER comment_search_update
 BEFORE INSERT OR UPDATE ON comment
 FOR EACH ROW
 EXECUTE PROCEDURE comment_search_update();

CREATE INDEX idx_search_comment ON comment USING GIN (tsvectors);


--TRIGGERS--


--every time a new vote is cast on a question, update the vote count of the question.
CREATE OR REPLACE FUNCTION update_question_votes()
RETURNS TRIGGER AS $$
BEGIN
   IF NEW.vote = TRUE THEN
      UPDATE question SET votes = votes + 1 WHERE id = NEW.question_id;
   ELSE
      UPDATE question SET votes = votes - 1 WHERE id = NEW.question_id;
   END IF;
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_update_question_votes
AFTER INSERT OR UPDATE ON voteQuestions
FOR EACH ROW
EXECUTE FUNCTION update_question_votes();


--every time a new vote is cast on a comment, update the vote count of the comment.
CREATE OR REPLACE FUNCTION update_comment_votes()
RETURNS TRIGGER AS $$
BEGIN
   IF NEW.vote = TRUE THEN
      UPDATE comment SET votes = votes + 1 WHERE id = NEW.comment_id;
   ELSE
      UPDATE comment SET votes = votes - 1 WHERE id = NEW.comment_id;
   END IF;
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_update_comment_votes
AFTER INSERT OR UPDATE ON voteComment
FOR EACH ROW
EXECUTE FUNCTION update_comment_votes();


--if a questions is deleted, delete all comments, votes and notifications associated with it.
CREATE OR REPLACE FUNCTION delete_cascade_question()
RETURNS TRIGGER AS $$
BEGIN
   DELETE FROM notification WHERE questionId = OLD.id;
   RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_delete_cascade_question
AFTER DELETE ON question
FOR EACH ROW
EXECUTE FUNCTION delete_cascade_question();


--TRANSACTIONS--


------TRAN 01------

--insert a new question and its tags
BEGIN;
INSERT INTO question (date, title, content, usersId) VALUES
('2023-10-23 09:00:00', 'How to normalize a database?', 'I need help with database normalization. Any tips?', 1);
INSERT INTO questionTag (questionId, tagId) VALUES
(1, 1),
(1, 2);
COMMIT;


------TRAN 02------

--insert a new comment and its subcomment
BEGIN;
INSERT INTO comment (date, content, usersId, questionId) VALUES
('2023-10-23 10:30:00', 'You can start with the 1NF, 2NF, and 3NF.', 3, 1);
INSERT INTO commentOnComment (mainCommentId, subCommentId) VALUES
(1, 2);
COMMIT;

