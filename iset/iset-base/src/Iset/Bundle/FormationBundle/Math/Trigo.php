<?php

namespace Iset\Bundle\FormationBundle\Math; 

class Trigo
{
	public function cos($angle)
	{
		return cos($angle);  
	}

	public function sin($angle)
	{
		return sin($angle);  
	}

	public function tan($angle)
	{
		return $this->sin($angle)/$this->cos($angle);  
	}
}