from flask import Flask  #import flask to display the details in a web browser.
import requests
import pandas as pd

app = Flask(__name__)

@app.route('/')
def display_data():
    # Replace with actual RapidAPI key
    rapidapi_key = 'f854d839d5msh5c2a1d0064b4392p142469jsn13678ef23fbf'

    # Define the API endpoint URL
    url = "https://wft-geo-db.p.rapidapi.com/v1/geo/countries/NZ/places"

    # Define the headers with your RapidAPI key
    headers = {
        'x-rapidapi-host': "wft-geo-db.p.rapidapi.com",
        'x-rapidapi-key': rapidapi_key
    }

    # Make GET request to the API 
    response = requests.get(url, headers=headers)

    if response.status_code == 200:
        data = response.json()
        places = data.get("data", [])
        df = pd.DataFrame([
            {
                "Place ID": place["id"],
                "Place Name": place["name"],
                "Place Type": place["type"],
                "Region Code": place.get("regionCode", "N/A"),  # Use "N/A" if regionCode is not available
            }
            for place in places
        ])
        
        # Convert the DataFrame to an HTML table and wrap it in HTML tags
        html_table = df.to_html(classes='table table-bordered', index=False)
        
        # Create HTML to style
        styled_html = f'''
        <html>
        <head>
            <title>Data from API</title>
            <style>
                body {{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }}
                
                .container {{
                    text-align: center;
                    background-color: #f5f5f5;
                    border-radius: 10px;
                    padding: 20px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
                    width: 60%;  /* Adjust the width as needed */
                    height: 50%;
                }}
                
                .container th {{
                    background-color: #5F646A;
                    text-align: center;  /* Center-align table headers */
                    padding: 8px; /* Add padding to headers */
                }}
                
                .container table {{
                    text-align: center;
                    width: 100%;  /* Adjust the width as needed */
                    
                }}
                
                .container table tr {{
                    height: 40px; /* Set a fixed height for table rows */
                }}

            </style>
        </head>
        <body>
            <div class="container mt-4">
                <h1>Places in New Zealand</h1>
                {html_table}
            </div>
        </body>
        </html>
        '''
        return styled_html

    else:
        return "Error: Unable to retrieve data from the API"

if __name__ == '__main__':
    app.run(debug=True)

