import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class commonDal {
	private static final String MYSQL_CONNECTION_STRING = "jdbc:mysql://localhost/agile_board?user=root&password=team01";

	private Connection connect = null;
	private PreparedStatement statement = null;
	private ResultSet resultSet = null;

	public boolean isItValidLogin(String username, String password) {
		try {
			// This will load the MySQL driver, each DB has its own driver
			Class.forName("com.mysql.jdbc.Driver");
			// Setup the connection with the DB
			connect = DriverManager
					.getConnection(MYSQL_CONNECTION_STRING);

			statement = connect
					.prepareStatement("select UserName, Passwrd from tblCredentials where (UserName = ?) and(Passwrd = ?)");
			statement.setString(1, username);
			statement.setString(2, password);
			resultSet = statement.executeQuery();
			if (resultSet.next()) {
				writeResultSet(resultSet);
				return true;
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			close();
		}
		return false;
	}

	private void writeMetaData(ResultSet resultSet) throws SQLException {
		// Now get some metadata from the database
		// Result set get the result of the SQL query

		System.out.println("The columns in the table are: ");

		System.out.println("Table: " + resultSet.getMetaData().getTableName(1));
		for (int i = 1; i <= resultSet.getMetaData().getColumnCount(); i++) {
			System.out.println("Column " + i + " "
					+ resultSet.getMetaData().getColumnName(i));
		}
	}

	private void writeResultSet(ResultSet resultSet) throws SQLException {
		// ResultSet is initially before the first data set
		while (resultSet.next()) {
			// It is possible to get the columns via name
			// also possible to get the columns via the column number
			// which starts at 1
			// e.g. resultSet.getSTring(2);
			String user = resultSet.getString("UserName");
			String pass = resultSet.getString("Passwrd");
			System.out.println("User: " + user);
			System.out.println("Passwrd: " + pass);
		}
	}

	// You need to close the resultSet
	private void close() {
		try {
			if (resultSet != null) {
				resultSet.close();
			}

			if (statement != null) {
				statement.close();
			}

			if (connect != null) {
				connect.close();
			}
		} catch (Exception e) {

		}
	}

}
