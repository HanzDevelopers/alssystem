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

    // Display top 3 reasons and their solutions with "Read more" modals
    topReasons.forEach((reasonObj, index) => {
        const shortText = solutions[index].length > 1000 ? solutions[index].substring(0, 1000) + '...' : solutions[index];
        const modalId = `modal-${index}`;

        const reasonDiv = document.createElement('div');
        reasonDiv.innerHTML = `
            <h3>Reason: <span style="font-weight: bold; font-style: italic; text-decoration: underline;">${reasonObj.reason}</span> (Count: ${reasonObj.count})</h3>
            <p style="font-size: 15px;">Solution: ${shortText}
                <a href="#" style="color: blue; text-decoration: underline;" onclick="fetchAndShowModalSolution('${modalId}', \`${reasonObj.reason}\`); return false;">Read more</a>
            </p>

            <!-- Modal -->
            <div id="${modalId}" class="modal" style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4);">
                <div style="background-color:#fff; margin:10% auto; padding:20px; border:1px solid #888; width:80%; border-radius: 10px; max-height: 70%; overflow-y: auto;">
                    <span style="float:right; font-size:28px; font-weight:bold; cursor:pointer;" onclick="closeModal('${modalId}')">&times;</span>
                    <h3>Full Solution for: ${reasonObj.reason}</h3>
                    <p id="${modalId}-content" style="font-size: 15px;">Loading...</p>
                </div>
            </div>
        `;
        solutionsDiv.appendChild(reasonDiv);
    });

    // General Solution with modal
    const generalModalId = "modal-general";
    const shortGeneral = otherReasonsSolution.length > 350 ? otherReasonsSolution.substring(0, 350) + '...' : otherReasonsSolution;

    const otherDiv = document.createElement('div');
    otherDiv.innerHTML = `
        <h3>General Solution:</h3>
        <p style="font-size: 15px;">${shortGeneral}
            <a href="#" style="color: blue; text-decoration: underline;" onclick="fetchAndShowModalSolution('${generalModalId}', 'general solutions for various other reasons for not attending school'); return false;">Read more</a>
        </p>

        <!-- Modal for general solution -->
        <div id="${generalModalId}" class="modal" style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4);">
            <div style="background-color:#fff; margin:10% auto; padding:20px; border:1px solid #888; width:80%; border-radius: 10px; max-height: 70%; overflow-y: auto;">
                <span style="float:right; font-size:28px; font-weight:bold; cursor:pointer;" onclick="closeModal('${generalModalId}')">&times;</span>
                <h3>Full General Solution</h3>
                <p id="${generalModalId}-content" style="font-size: 15px;">Loading...</p>
            </div>
        </div>
    `;
    solutionsDiv.appendChild(otherDiv);
}

function showModal(id) {
    document.getElementById(id).style.display = 'block';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Initialize fetch function
fetchReasons();
