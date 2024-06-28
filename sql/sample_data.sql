INSERT INTO customers (name, email) VALUES ('John Doe', 'john@example.com');
INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (1, 'Great product!', 5, 'Product');
INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (1, 'Could be improved.', 3, 'Service');
INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (1, 'great', 0.9);
INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (2, 'improved', 0.5);
INSERT INTO users (username, password, role) VALUES ('admin', 'adminpass', 'admin');
INSERT INTO users (username, password, role) VALUES ('manager', 'managerpass', 'manager');
INSERT INTO feedback_responses (feedback_id, user_id, response_text) VALUES (1, 2, 'Thank you for your feedback!');
