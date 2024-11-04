async function fetchReasons() {
    try {
        // Fetch reasons and counts from the server
        const response = await fetch('../api/get_top_reasons.php');
        const reasons = await response.json();

        // Show loading indicator
        document.getElementById('loading-container').style.display = 'flex';

        // Separate top 3 reasons from "other reasons"
        const topReasons = reasons.slice(0, 3);
        const otherReasons = reasons.slice(3); // Remaining reasons, if any

        // Generate a solution for each of the top reasons
        const solutions = await Promise.all(topReasons.map(reasonObj => generateSolution(reasonObj.reason)));

        // Hide loading and show solutions
        document.getElementById('loading-container').style.display = 'none';
        document.getElementById('solutions').style.display = 'block';

        // Format other reasons text and generate a general solution
        const otherReasonsText = otherReasons.map(other => `<strong>${other.reason}</strong>: ${other.count}`).join('<br>');
        const otherReasonsSolution = await generateSolution("general solutions for various other reasons for not attending school");

        // Display solutions
        displaySolutions(topReasons, solutions, otherReasonsText, otherReasonsSolution);
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

function displaySolutions(topReasons, solutions, otherReasonsText, otherReasonsSolution) {
    const solutionsDiv = document.getElementById('solutions');


    // Display top 3 reasons and their solutions
    topReasons.forEach((reasonObj, index) => {
        const reasonDiv = document.createElement('div');
        reasonDiv.innerHTML = `<h3>Reason: <span  style="font-weight: bold;  font-style: italic; text-decoration: underline;">${reasonObj.reason}</span> (Count: ${reasonObj.count})</h3><p style="font-size: 15px;">Solution: ${solutions[index]}</p>`;
        solutionsDiv.appendChild(reasonDiv);
    });

    // Display general solution
    const otherDiv = document.createElement('div');
    otherDiv.innerHTML = `<h3>General Solution:</h3><p style="font-size: 15px;"> ${otherReasonsSolution}</p>`;
    solutionsDiv.appendChild(otherDiv);
}

// Initialize fetch function
fetchReasons();
