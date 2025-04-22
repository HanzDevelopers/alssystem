<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Reasons & Solutions</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }
        
        /* Solution container styling */
        #solutions {
            display: none; /* Hidden initially, shown after loading */
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Loading container styling */
        #loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Loading text */
        #loading-text {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 15px;
        }

        /* Spinner styling */
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top-color: #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Spinner animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading indicator container -->
    <div id="loading-container">
        <div id="loading-text">Generating solutions, please wait...</div>
        <div class="spinner"></div>
    </div>

    <!-- Solutions container, initially hidden -->
    <div id="solutions">
        <h2>Top 3 Reasons for Not Attending School and AI-Generated Solutions</h2>
        <!-- Solutions will be dynamically inserted here -->
    </div>

    <script>
        async function fetchReasons() {
            try {
                // Fetch the top reasons from the server
                const response = await fetch('get_top_reasons.php');
                const reasons = await response.json();

                // Show loading indicator
                document.getElementById('loading-container').style.display = 'flex';

                // Generate a solution for each reason individually
                const solutions = await Promise.all(reasons.map(reasonObj => generateSolution(reasonObj.reason)));

                // Hide loading container and show solutions container
                document.getElementById('loading-container').style.display = 'none';
                document.getElementById('solutions').style.display = 'block';

                // Display solutions in the solutions container
                displaySolutions(reasons, solutions);
            } catch (error) {
                console.error("Error fetching reasons:", error);
                document.getElementById('loading-container').style.display = 'none';
            }
        }

        async function generateSolution(reason) {
            const prompt = `What would be a helpful solution to address the reason for not attending school: "${reason}"?`;

            try {
                const response = await fetch("https://api-inference.huggingface.co/models/meta-llama/Llama-3.2-11B-Vision-Instruct", {
                    method: "POST",
                    headers: {
                        "Authorization": "Bearer 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",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        inputs: prompt,
                        parameters: { max_new_tokens: 150 }
                    })
                });

                const data = await response.json();

                if (data && Array.isArray(data) && data[0]?.generated_text) {
                    return data[0].generated_text.trim();
                } else if (data.generated_text) {
                    return data.generated_text.trim();
                } else {
                    console.error("Unexpected response format:", data);
                    return "Solution not available.";
                }
            } catch (error) {
                console.error("Error fetching solution:", error);
                return "An error occurred while generating a solution.";
            }
        }

        function displaySolutions(reasons, solutions) {
            const solutionsDiv = document.getElementById('solutions');

            reasons.forEach((reasonObj, index) => {
                const reasonDiv = document.createElement('div');
                reasonDiv.innerHTML = `<h3>Reason: ${reasonObj.reason} (Count: ${reasonObj.count})</h3><p>Solution: ${solutions[index]}</p>`;
                solutionsDiv.appendChild(reasonDiv);
            });
        }

        fetchReasons();
    </script>
</body>
</html>
