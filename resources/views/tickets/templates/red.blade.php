<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #ffe6e6;
    }

    /* Ticket card styling */
    .ticket-card {
        width: 100%;
        max-width: 600px;
        background: linear-gradient(135deg, #b22222, #ff6347);
        border-radius: 12px;
        color: #fff;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        margin: 20px;
        border: 1px solid #8b0000;
    }

    .ticket-header {
        background-color: rgba(255, 228, 225, 0.1);
        padding: 20px;
        text-align: center;
        font-size: 1.8em;
        font-weight: bold;
        color: #ffebee;
    }

    .ticket-body {
        padding: 25px 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: #b22222;
    }

    .ticket-info {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        border-radius: 8px;
        padding: 15px;
        background-color: rgba(255, 255, 255, 0.1);
        margin-bottom: 15px;
    }

    .ticket-info div {
        flex: 1 1 45%;
        margin-bottom: 10px;
        font-size: 1em;
    }

    .ticket-info span {
        font-weight: bold;
        color: #ffdab9;
    }

    .ticket-footer {
        padding: 15px;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.1);
        font-size: 0.9em;
        color: #ffb6c1;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 15px;
    }

    .action-buttons button {
        background-color: #fff;
        color: #b22222;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .action-buttons button:hover {
        background-color: #b22222;
        color: #fff;
    }

    /* Print-specific styles */
    @media print {
        .action-buttons {
            display: none;
        }
    }

    @media (min-width: 600px) {
        .ticket-body {
            flex-direction: row;
        }
        .ticket-info {
            flex-direction: row;
            gap: 15px;
        }
    }
</style>