INSERT OR IGNORE INTO customers (name, email) VALUES ('John Doe', 'john@example.com');
INSERT OR IGNORE INTO customers (name, email) VALUES ('Priya Singh', 'priya@example.com');
INSERT OR IGNORE INTO customers (name, email) VALUES ('Miguel Reyes', 'miguel@example.com');

INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (1, 'Great product! Setup was smooth and the interface is intuitive.', 5, 'Product');
INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (2, 'Service team resolved my issue but the response was a bit slow.', 3, 'Service');
INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (3, 'The documentation could be more detailed for new users.', 4, 'Other');

INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (1, 'great', 0.9);
INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (1, 'intuitive', 0.9);
INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (2, 'slow', -0.2);
INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (3, 'documentation', 0.2);

INSERT OR IGNORE INTO users (username, password, role) VALUES ('admin', 'adminpass', 'admin');
INSERT OR IGNORE INTO users (username, password, role) VALUES ('manager', 'managerpass', 'manager');
INSERT OR IGNORE INTO users (username, password, role) VALUES ('support', 'supportpass', 'manager');

INSERT INTO feedback_responses (feedback_id, user_id, response_text) VALUES (1, 2, 'Thank you for your feedback!');
