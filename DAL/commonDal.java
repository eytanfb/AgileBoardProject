
public class commonDal {
	
	public boolean isItValidLogin(String username , String password)
	{
		// write your data access layer code here
		if (username.equalsIgnoreCase("a") && password.equalsIgnoreCase("a") )
		{
			return true;
		}
		else
			return false;
			
	}

}
