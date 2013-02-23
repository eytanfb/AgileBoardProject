

import java.io.IOException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.catalina.connector.Request;

/**
 * Servlet implementation class login
 */
@WebServlet("/login")
public class login extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public login() {
        super();
        // TODO Auto-generated constructor stub
    }

	
	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		
		String username = request.getParameter("txtusername");
		String password = request.getParameter("txtpassword");
		if ( username!=null && password!=null && username.equalsIgnoreCase("1") && password.equalsIgnoreCase("1"))
		{
			RequestDispatcher d = request.getRequestDispatcher("/index.jsp");
			d.forward(request, response);
		}
		else
		{
		request.setAttribute("message", "Invalid username/password");
		RequestDispatcher d = request.getRequestDispatcher("/login.jsp");
		d.forward(request, response);
		}
	}
	
	

}
