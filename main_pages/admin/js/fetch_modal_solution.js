async function fetchAndShowModalSolution(modalId, reason) {
    const modal = document.getElementById(modalId);
    const content = document.getElementById(`${modalId}-content`);

    // Set loading state before fetching
    content.innerHTML = `
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="spinner" style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite;"></div>
            <span>Loading solution...</span>
        </div>
    `;
    modal.style.display = 'block';

    const prompt = `What would be a complete and helpful solution to address the reason for not attending school: "${reason}"?`;

    try {
        const response = await fetch("https://api-inference.huggingface.co/models/meta-llama/Llama-3.2-11B-Vision-Instruct", {
            method: "POST",
            headers: {
                "Authorization": "Bearer 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",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                inputs: prompt,
                parameters: { max_new_tokens: 500 }
            })
        });

        const data = await response.json();
        let fullText = "Solution not available.";
        if (data && Array.isArray(data) && data[0]?.generated_text) {
            fullText = data[0].generated_text.trim();
        } else if (data.generated_text) {
            fullText = data.generated_text.trim();
        }

        content.innerText = fullText;
    } catch (error) {
        console.error("Error fetching modal solution:", error);
        content.innerText = "An error occurred while loading the solution.";
    }
}
