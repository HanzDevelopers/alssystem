async function fetchReasons() {
    try {
        const response = await fetch('../api/get_top_reasons.php');
        const reasons = await response.json();

        document.getElementById('loading-container').style.display = 'flex';

        const topReasons = reasons.slice(0, 3);
        const otherReasons = reasons.slice(3);

        document.getElementById('loading-container').style.display = 'none';
        document.getElementById('solutions').style.display = 'block';

        displayReasonsOnly(topReasons, otherReasons);
    } catch (error) {
        console.error("Error fetching reasons:", error);
        document.getElementById('loading-container').style.display = 'none';
    }
}

function displayReasonsOnly(topReasons, otherReasons) {
    const solutionsDiv = document.getElementById('solutions');

    topReasons.forEach((reasonObj, index) => {
        const modalId = `modal-${index}`;

        const reasonDiv = document.createElement('div');
        reasonDiv.innerHTML = `
            <h3>Reason: <span style="font-weight: bold; font-style: italic; text-decoration: underline;">${reasonObj.reason}</span> (Count: ${reasonObj.count})</h3>
            <p style="font-size: 15px;">Solution:
                <a href="#" onclick="fetchAndShowModalSolution('${modalId}', \`${reasonObj.reason}\`); return false;">Read more</a>
            </p>

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
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

fetchReasons();
