# DOMParserHTML
Get Elements HTML with Parsing Object

<h2>Clone Git</h2>

		$ git clone https://github.com/kangjeki/DOMParserHTML.git

<h2>Use</h2>

Load Default HTML in Active Page

    require  __DIR__ . '/DOMParserHTML/Autoload.php';
    use DOMParserHTML\Parser\DOMParser;
    
    $Doc 	= new DOMParser;
    
Load Manual HTML Elements, put html elements in parameter

    require  __DIR__ . '/DOMParserHTML/Autoload.php';
    use DOMParserHTML\Parser\DOMParser;
    
    $Doc 	= new DOMParser($html);
    
<h2>Methode Usage</h2>
<b>Selector</b>

    $Doc 	  = new DOMParser;
    $input    = $Doc->getElementById("idElement");
    
    // output is HTML input Elements
    
<b>Metode</b>

    $Doc 	  = new DOMParser;
    $input    = $Doc->getElementById("idElement");
    
    $value    = $Doc->value($input);
    
    // Output is Value of Input Element
    
# All Selector
<table>
	<tr>
		<th>Methode</th>
		<th>Param (String)</th>
		<th>Note</th>
		<th>Return</th>
	</tr>
	<tr>
		<td>
			querySelector(<i>param</i>);
		</td>
		<td>
			"table" <br>
			"#select" <br>
			".select" 
		</td>
		<td>
			Select Tag Element <br>
			Select Id <br>
			Select Class
		</td>
		<td>
			html elements Target Select
		</td>
	</tr>
	<tr>
		<td>
			querySelectorAll(<i>param</i>);
		</td>
		<td>
			"input" <br>
			".select"
		</td>
		<td>
			Select All Tag Element <br>
			Select All Class
		</td>
		<td>
			Object | Return All Elements Exist
		</td>
	</tr>
	<tr>
		<td>
			getElementById(<i>param</i>);
		</td>
		<td>
			"targetId"	
		</td>
		<td>
			Select Element Id
		</td>
		<td>
			html elements Select
		</td>
	</tr>
	<tr>
		<td>
			getElementsByTagName(<i>param</i>);
		</td>
		<td>
			"tagElement"
		</td>
		<td>
			Select Element Tag Name
		</td>
		<td>
			Object | Return All Elements Exist
		</td>
	</tr>
	<tr>
		<td>
			getElementsByClassName(<i>param</i>);
		</td>
		<td>
			"className" 	
		</td>
		<td>
			Select Element Class Name
		</td>
		<td>
			Object | Return All Class Name Exist
		</td>
	</tr>
</table>

# All Methode
<table>
	<tr>
		<th>
			Methode
		</th>
		<th>
			Param
		</th>
		<th>
			Note
		</th>
		<th>
			Return
		</th>
	</tr>
	<tr>
		<td>
			value(<i>param</i>);
		</td>
		<td>
			input element
		</td>
		<td>
			param is HTML Element
		</td>
		<td>
			value of element
		</td>
	</tr>
	<tr>
		<td>
			classList(<i>param</i>);
		</td>
		<td>
			html element
		</td>
		<td>
			-
		</td>
		<td>
			Auto | All Class List in Element
		</td>
	</tr>
	<tr>
		<td>
			id(<i>param</i>);
		</td>
		<td>
			html Element
		</td>
		<td>
			-
		</td>
		<td>
			id name element
		</td>
	</tr>
	<tr>
		<td>
			getAttribute(<i>param 1</i>, <i>param 2</i>);
		</td>
		<td>
			1. html element <br>
			2. (string)
		</td>
		<td>
			1. html element <br>
			2. spesific attribute name 
		</td>
		<td>
			value of attribute name
		</td>
	</tr>
	<tr>
		<td>
			existClass(<i>param 1</i>, <i>param 2</i>);
		</td>
		<td>
			1. html element <br>
			2. (string)
		</td>
		<td>
			1. Sepesific html element <br>
			2. class name
		</td>
		<td>
			(bool) | true/false
		</td>
	</tr>
</table>

<h1>More Example</h1>
<b>Get Child Element</b>

    require  __DIR__ . '/DOMParserHTML/Autoload.php';
    use DOMParserHTML\Parser\DOMParser;
    
    $Doc 	= new DOMParser;
    $elem   = $Doc->querySelector("#data-url");
    
    $DataURL  = new DOMParser($elem);
    $url      = $DataURL->querySelectorAll("a");
    
    // output $url is list of all tag (a) elements
    
    /* example html structur */
    <div id="data-url">
        <a href="...">URL 1</a>
        <a href="...">URL 2</a>
        <a href="...">URL 3</a>
        <a href="...">URL 4</a>
    </div>
