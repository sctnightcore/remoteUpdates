using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class ConsoleUpdate : MonoBehaviour
{

    public string Botname;
    public string host_address;
    public InputField command;
    public GameObject console_h;
    public GameObject text_prefab;

    public void Start()
    {
        if (PlayerPrefs.GetString("external_use") == "sim")
        {
            host_address = PlayerPrefs.GetString("host_address_external");
        }
        else
        {
            host_address = PlayerPrefs.GetString("host_address");
        }
    }

    public void SendCommand()
    {
        StartCoroutine(SendConsoleCommand(command.text));
        GameObject temp_text = Instantiate(text_prefab) as GameObject;
        temp_text.GetComponent<Text>().text = command.text;
        temp_text.transform.SetParent(console_h.transform);
        command.text = "";
    }

    IEnumerator SendConsoleCommand(string comando)
    {
        WWWForm form = new WWWForm();
        form.AddField("req_type", "save_command");
        form.AddField("name", Botname);
        form.AddField("command", comando);

        UnityWebRequest www = UnityWebRequest.Post(host_address + "/remoteUpdatesPhp/main.php", form);
        yield return www.SendWebRequest();

        if (www.isNetworkError || www.isHttpError)
        {
            Debug.Log(www.error);
        }
    }
}
