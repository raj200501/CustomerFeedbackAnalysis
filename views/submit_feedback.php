<?php include 'header.php'; ?>
<h1>Submit Feedback</h1>
<form method="post" action="submit_feedback.php">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="feedback">Feedback:</label>
    <textarea id="feedback" name="feedback" required></textarea>
    <br>
    <label for="rating">Rating:</label>
    <input type="number" id="rating" name="rating" min="1" max="5" required>
    <br>
    <label for="feedback_type">Feedback Type:</label>
    <select id="feedback_type" name="feedback_type" required>
        <option value="Product">Product</option>
        <option value="Service">Service</option>
        <option value="Other">Other</option>
    </select>
    <br>
    <button type="submit">Submit</button>
</form>
<?php include 'footer.php'; ?>
